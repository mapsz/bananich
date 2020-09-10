<template>
<div class="modal-tab-pane active">
  <div class="modal-form">
    <!-- Inputs -->
    <div>
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
          v-model="surname"
          placeholder="Фамилия*" 
          id="surname" 
          type="text" 
          class="modal-sad-form-input" 
          name="surname"   
          required 
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
          v-model="email"
          placeholder="E-mail*" 
          id="email" 
          type="email" 
          class="modal-sad-form-input" 
          name="email"    
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
      <div class="modal-sad-form-group">
        <input 
          v-model="referral"
          placeholder="Телефон кто порекомендовал нас" 
          id="referral" 
          type="text" 
          class="modal-sad-form-input" 
          name="referral" 
        >
      </div>
    </div>

    <!-- Errors -->
    <ul>
      <template v-for='error in errors'>
        <li v-for='err in error' :key="err" style="color:tomato">
          {{err}}
        </li>
      </template>
    </ul>

    <!-- Buttons -->
    <div class="modal-sad-form-btn">
      <button @click="singup()" class="btn-yellow btn-thick">Зарегистрироваться</button>
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    name:'',
    surname:'',
    phone:'',
    email:'',
    password:'',
    password_confirmation:'',
    referral:'',
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    errors:[],
  }},
  computed:{
    ...mapGetters({user:'user/get'}), 
  },
  methods:{
    ...mapActions({'getUser':'user/fetch',}), 
    async singup(){

      //Refresh errors
      this.errors = [];

      //Setup data
      let data  = {
        '_token':this.csrf,
        'name':this.name,
        'surname':this.surname,
        'phone':this.phone,
        'email':this.email,
        'password':this.password,
        'password_confirmation':this.password_confirmation,
      };

      if(this.referral){
        data.referral = this.referral;
      }

      //Post
      let r = await ax.fetch('/register', data, 'post');
      let registerResponse = ax.lastResponse;

      //Check signin
      await this.getUser();
      if(this.user)location.reload();

      //Catch errors
      if(!r){      
        if(registerResponse.status == 422){
          this.errors = registerResponse.data.errors;
          return;
        }
      }

    }
  }
}
</script>

<style>

</style>