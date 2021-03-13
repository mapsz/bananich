<template>  
    <main class="home">
      <div class="container">

        <!-- Breadcrumbs -->
        <Breadcrumbs />

        <div class="row content-page">
          <!-- Navbar -->
          <div class="col-lg-4">            
            <profile-navbar></profile-navbar>
          </div>          
          <div class="col-lg-8">
            
            <!-- Title -->
            <div class="title-wrap title-page">
              <h2 class="title-h2">Личные данные</h2>
            </div>   

            <div class="content">

              <!-- Avatar -->
              <div v-if="0" class="row mb-4">
                <div class="col-12">
                  <h4 class="mb-3">Аватарка</h4>
                  <div class="">
                    <div class="user-avatar">
                      <img alt="Avatar" :src="user.mainImage" style="max-width: 100%; max-height: 100%; border-radius: 50px;">
                    </div>
                    <button @click="avatarUploadShow=true" class="form-url" style="margin-top:0px">Редактировать</button>     
                    <!-- Upload avatar -->
                    <x-popup v-if="avatarUploadShow" :title="'Редактирование аватара'" :active="avatarUploadShow" @close="avatarUploadShow=false" id="avatar-upload-modal">
                      <div class="m-3">                        
                        <!-- File -->
                        <div>      
                          <file-upload
                            v-model="avatarFile"
                            :file-type="'image/*'" 
                            :max-file-count="1" 
                            :value="avatarFile"
                          />
                        </div>
                        

                      </div>
                    </x-popup>
                  </div>
                </div>
              </div>

              <!-- Личные данные / Address -->
              <div class="row">

                <!-- Личные данные -->
                <div class="col-12 col-lg-6">
                  <h4 class="mb-3">Контактные данные</h4>
                  <div class="form-group">
                    <label  class="form-label" for="surname">Ваш e-mail</label>
                    <div class="form-content active">{{user.email}}</div>
                  </div>
                  <form class="profile-form" action="" style="border-bottom:0px;padding-bottom:0px;">
                    <div class="form-group" v-for='(input,i) in contactInputs' :key='i'>
                      <label  class="form-label" :for="input.name">{{input.caption}}</label>
                      <div v-if="editContact==false" class="form-content active">
                        <template v-if="data[input.name] !== undefined">
                          <template v-if="data[input.name]">{{data[input.name]}}</template>
                          <template v-else><span style="color:gray;font-size: 10pt;font-style: italic;">не указано</span></template>
                        </template>
                      </div>
                      <input v-model="data[input.name]" v-if="editContact==true" :id="input.name" class="form-input " type="text">
                    </div>
                    <div class="form-button" style="margin-top:0px">
                      <button v-if="editContact==false" @click.prevent="editContact=true" class="form-url" style="margin-top:0px">Редактировать личные данные</button>
                      <button @click.prevent="doEdit()" v-if="editContact==true" class="btn-yellow btn-big">Сохранить изменения</button>
                    </div>
                  </form>
                </div>

                <!-- Address -->
                <div class="col-12 col-lg-6  mt-5 mt-lg-0">
                  <h4>Адрес</h4>

                  <!-- Show -->
                  <div class="">
                    <show-address v-if="defaultAddress" :address="defaultAddress" />
                    <button v-if="showAddresses==false" @click.prevent="showAddresses=true" class="form-url mt-2" style="margin-top:0px">Редактировать адрес</button>
                    <user-addresses :active="showAddresses" @close="showAddresses=false" />
                  </div>
                </div>

                <!-- Address-old -->
                <div v-if="0" class="col-12 col-lg-6">
                  <h4 class="mb-3">Адрес</h4>

                  <form class="profile-form"  style="border-bottom:0px">
                    <div class="form-group" v-for='(input,i) in addressInputs' :key='i'>
                      <label  class="form-label" :for="input.name">{{input.caption}}</label>
                      <div v-if="editAddress==false" class="form-content active">
                        <template v-if="dataAddress[input.name] !== undefined">
                          <template v-if="dataAddress[input.name]">{{dataAddress[input.name]}}</template>
                          <template v-else><span style="color:gray;font-size: 10pt;font-style: italic;">не указано</span></template>
                        </template>
                      </div>
                      <input v-model="dataAddress[input.name]" v-if="editAddress==true" :id="input.name" class="form-input " type="text">
                    </div>
                    <div class="form-button" style="margin-top:0px">
                      <button v-if="editAddress==false" @click.prevent="editAddress=true" class="form-url" style="margin-top:0px">Редактировать адрес</button>
                      <button @click.prevent="doEditAddress()" v-if="editAddress==true" class="btn-yellow btn-big">Сохранить изменения</button>
                    </div>
                  </form>                  
                </div>

              </div>
              
              <!-- Logout -->
              <div class="row mt-5 mt-lg-0">
                <div class="col-12">
                  <logout />
                </div>
              </div>

            </div>
              
          </div>
        </div>
      </div>
    </main>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {  
  data(){return{
    isX:isX,
    showAddresses:false,
    contactInputs:[
      {caption:'Ваше имя',name:'name'},
      {caption:'Ваша фамилия',name:'surname'},
      {caption:'Ваш телефон',name:'phone'},
    ],
    addressInputs:[
      {caption:'Улица',name:'street'},
      {caption:'Дом',name:'number'},
      {caption:'Квартира',name:'appart'},
      {caption:'Подъезд',name:'porch'},
    ],

    avatarFile:null,
    data:{},
    dataAddress:{street:'',number:'',appart:'',porch:''},
    editContact:false,
    editAddress:false,
    avatarUploadShow:false,
  }},
  computed:{
    ...mapGetters({user:'user/get'}),
    defaultAddress(){
      if(!this.user == undefined || !this.user.addresses == undefined) return false; 
      if(!this.user.addresses || this.user.addresses.length < 1) return false;
      let d = this.user.addresses.find(x => x.default == 1);      
      if(d) return d;
      //No default
      return this.user.addresses[1]; 
    },
  },
  watch: {
    avatarFile: function (val, oldVal) {
      console.log(val);
    },
    user: {
      handler: function (val, oldVal) {
        this.data.name      = this.user.name;
        this.data.surname   = this.user.surname;
        this.data.phone     = this.user.phone;

        if(this.user.addresses != undefined && this.user.addresses[0]){
          this.dataAddress.street = this.user.addresses[0].street;
          this.dataAddress.number = this.user.addresses[0].number;
          this.dataAddress.appart = this.user.addresses[0].appart;
          this.dataAddress.porch = this.user.addresses[0].porch;
        }
      },
      deep: true
    }
  },
  methods:{
    ...mapActions({'editUser':'user/edit','editUserAddress':'user/editAddress'}),
    doEdit(){
      this.editUser(this.data);
      this.editContact=false;
    },
    doEditAddress(){
      this.editUserAddress(this.dataAddress);
      this.editAddress=false;
    }
  },
}
</script>

<style>

</style>