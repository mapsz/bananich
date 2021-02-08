<template>
<div class="user-addresses">

  
  <!-- List -->
  <x-popup  :title="title" :active="showAddresses" @close="showAddresses=false" id="user-addresses-list-modal">
    <div class="my-3">

      <!-- Add new button -->
      <div v-if="!isAction">
        <button @click="showAdd=true" class="mb-3" style="text-decoration:underline">
          <b>Добавить новый адрес</b> 
        </button>
      </div>

      <!-- List -->
      <template v-if="!isAction">
        <div v-for="(address, i) in addresses" :key="i" 
          style="border: 1px solid black;border-radius: 10px;padding: 10px; margin-bottom:10px"
          :style="
            (address.default ? 'font-weight: 600;' : '') +
            (address.id == choosedAddress ? 'background-color: #8ac2a73b' : '')
          "
        >      

          <!-- Actions -->
          <div class="d-flex justify-content-between mb-2">
            <!-- Default -->
            <div>
              <button v-if="!address.default" @click="setDefault(address.id)" class="addresses-action-buttons" style="margin-top:0px">
                Использовать по умолчанию         
              </button>
              <span  v-else class="addresses-action-buttons" style="text-decoration: none;">
                Адрес по умолчанию
              </span>
            </div>
            <!-- Edit -->
            <button @click="showEdit=address.id" class="addresses-action-buttons" style="margin-top:0px">Редактировать</button>
          </div>

          <!-- Data / Delete -->
          <div class="d-flex justify-content-between">
            <!-- Data -->
            <div>
              <show-address :address="address" />
            </div>
            <!-- Delete -->
            <div>
              <button @click="showDelete=address.id" class="x-btn x-btn-trans" style="height: 40px; width: 40px; padding: 0px;">🗑️</button>
            </div>
          </div>

          <!-- Choose -->
          <div v-if="choose && address.id != choosedAddress" class="d-flex justify-content-between mt-2">
            <button @click="doChoose(address.id)" class="x-btn" style="height: 40px;">Выбрать этот адрес</button>
          </div>

        </div>
      </template>
      
      <!-- Actions -->
      <template>
        <!-- Add -->
        <div v-if="showAdd">
          <show-edit-address @success="actionSuccess()" @cancel="showAdd=false"/>
        </div>
        <!-- Edit -->
        <div v-if="showEdit">
          <show-edit-address :id="showEdit" @success="actionSuccess()" @cancel="showEdit=false"/>
        </div>

        <!-- Delete -->
        <div v-if="showDelete">
          <div>
            Удалить <b>{{actionAddress.street}}</b> ?
          </div>
          <div class="d-flex justify-content-between">
            <button @click="showDelete=false" class="x-btn x-btn-trans x-btn-sm mt-3">Отмена</button>
            <button @click="deleteAddress(showDelete)" class="x-btn x-btn-red x-btn-sm mt-3">Удалить</button>
          </div>
        </div>
        

      </template>

    </div>
  </x-popup>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['active','choose'],
data(){return{
  //Choose
  choosedAddress:false,
  defautSet:false,
  //Show
  showAddresses:false,
  showDelete:false,
  showAdd:false,
  showEdit:false,
  //Other
  errors:[],
}},
computed:{
  ...mapGetters({
    user:'user/get',
  }),
  title(){
    if(this.showDelete) return 'Удаление адреса';
    if(this.showAdd) return 'Добавление адреса';
    if(this.showEdit) return 'Редактирование адреса';
    
    return 'Список ваших адресов';
  },
  isAction(){
    if(this.showDelete || this.showAdd || this.showEdit) return true;    
    return false;
  },
  addresses(){
    if(!this.user == undefined || !this.user.addresses == undefined) return false;
    return this.user.addresses;
  },
  dAddress(){
    if(!this.addresses || this.addresses.length < 1) return false;
    return this.addresses.find(x => x.default == 1);
  },
  actionAddress(){
    let actionId = false;
    if(this.showDelete) actionId = this.showDelete;

    if(!actionId) return false;

    return this.addresses.find(x => x.id == actionId);
  }
},
watch:{
  active: function (val, oldVal) {
    this.showAddresses = this.active;
  },
  showAddresses: function (val, oldVal) {
    if(!this.showAddresses) this.$emit('close');
  },
  addresses: function(){
    if(this.addresses && this.addresses.length == 0) this.showAdd = true;
  },
  user: function (val, oldVal) {
    this.watchUserLoad();
  },
},
async mounted() {
  this.watchUserLoad();
},
methods:{
  ...mapActions({
    'getUser':'user/fetch',
  }),
  watchUserLoad(){
    if(!this.choose) return;
    if(this.defautSet) return;
    if(this.user == undefined || this.user.id == undefined) return;
    let d = this.addresses.find(x => x.default == 1);
    if(d) this.doChoose(d.id);
    this.defautSet = true;
  },
  async setDefault(id){
    await ax.fetch('/user/address/default', {id}, 'post');
    this.getUser();
  },
  async deleteAddress(id){
    let r = await ax.fetch('/user/address', {id}, 'delete');
    if(r) {
      this.actionSuccess();
    }    
  },
  async actionSuccess(){
    await this.getUser();

    if(this.choose && this.addresses.length == 1 && (this.showAdd || this.showEdit)) this.doChoose(this.addresses[0].id);
    
    this.showDelete = false;
    this.showEdit = false;
    this.showAdd = false;
  },
  doChoose(id){
    this.choosedAddress = id;
    this.$emit('choose', id);
    this.showAddresses = false
  }
},
}
</script>

<style scoped>
  /* Buttons */
  .addresses-action-buttons{
    text-decoration: underline;
    color: #918c8c;
    font-size: 10pt;
  }



  /* Desktop */
  @media screen and (min-width: 992px){
    /* Buttons */
    .addresses-action-buttons{
      font-size: 12pt;
    }
  }

</style>