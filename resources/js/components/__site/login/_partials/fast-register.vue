<template>
  <div class="my-5">

    <!-- Make password -->
    <div v-if="link">
      <div class="d-flex justify-content-center">
        <div class="modal-form" style="width:300px">          
          <div>
            <!-- Inputs -->
            <template>
              <div class="modal-sad-form-group">
                <input 
                  v-model="name"
                  placeholder="Имя*" 
                  id="name" 
                  type="text" 
                  class="modal-sad-form-input" 
                  name="email"     
                  required 
                  autofocus
                >  
              </div>
              <div class="modal-sad-form-group">
                <input 
                  v-model="phone"
                  placeholder="Телефон*" 
                  id="phone" 
                  type="text" 
                  class="modal-sad-form-input" 
                  name="text"    
                  required 
                >  
              </div>
              <div class="modal-sad-form-group">
                <input 
                  v-model="password"
                  placeholder="Пароль*" 
                  id="password" 
                  type="password" 
                  class="modal-sad-form-input" 
                  name="password"   
                  required 
                >  
              </div>
              <div class="modal-sad-form-group">
                <input 
                  v-model="password_confirmation"
                  placeholder="Повторите пароль*" 
                  id="password-confirm" 
                  class="modal-sad-form-input" 
                  type="password" 
                  name="password_confirmation" 
                  required
                >
              </div>
            </template>
            <!-- Errors -->
            <juge-errors :errors="errors" />
            <!-- Button -->
            <div class="d-flex justify-content-center">
              <button @click="saveUser()" class="x-btn">Зарегистрироваться</button>
            </div>            
          </div>
        </div>
      </div>
    </div>

    <!-- Send link -->
    <div v-else>      
      <div v-if="!send">
        <div class="d-flex justify-content-center mb-3">
          <input v-model="email" type="email" placeholder="Укажите ваш емэил" class="modal-sad-form-input">
        </div>
        <div class="d-flex justify-content-center">
          <button class="x-btn" @click="makeLink()">Регистрироваться</button>
        </div>
        <!-- Errors -->
        <juge-errors :errors="errors" />
      </div>
      <div v-else>
        Спасибо за регистрацию. На указанный вами мейл {{email}} было отправлено письмо с дальнейшими инструкциями.
      </div>
    </div>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  name:'',
  phone:'',
  password:'',
  password_confirmation:'',
  email:"",
  send:false,
  errors:[],
}},
computed:{
  ...mapGetters({
    user:       'user/get',
  }),
  link(){
    if(this.$route.params == undefined || this.$route.params.link == undefined || this.$route.params.link == '') return false;
    return this.$route.params.link;
  }
},
watch:{
  user: function (val, oldVal) {
    if(this.user != undefined && this.user.id != undefined) {location.href = '/'}
  },
},
methods:{
  async makeLink(){
    this.errors = [];
    let r = await ax.fetch('/fast/register',{email:this.email},'put');    
    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}
    if(r) this.send = true;
  },
  async saveUser(){
    this.errors = [];
    let r = await ax.fetch('/fast/register/user',
    {
      'link':this.link,
      'name':this.name,
      'phone':this.phone,
      'password':this.password,
      'password_confirmation':this.password_confirmation}
    ,'put');

    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

    //Success
    if(r) location.reload();
  }
},
}
</script>

<style>

</style>