<template>
<div class="modal-sad-form">
  <!-- Email -->
  <div class="modal-sad-form-group">
    <input 
      v-model="email"
      placeholder="Email" 
      id="email" type="email" 
      class="modal-sad-form-input" 
      name="email"       
      value="" 
      required 
      autofocus
    >  
  </div>
  <!-- Password -->
  <div class="modal-sad-form-group">
    <input 
      v-model="password"
      placeholder="Пароль" 
      id="password" 
      type="password" 
      class="modal-sad-form-input" 
      name="password" 
      required 
      autocomplete="current-password"
    >
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
    <!-- Login -->
    <button @click="singin()" class="btn-yellow btn-enter">Войти</button> 
    <!-- Remind password -->
    <a class="forgot-password" href="/password/reset">Забыли пароль</a>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  email:"",
  password:'',
  csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  errors:[],
}},  
computed:{
  ...mapGetters({user:'user/get'}), 
},
methods:{
  ...mapActions({'getUser':'user/fetch',}), 
  async singin(){

    //Refresh errors
    this.errors = [];

    //Setup data
    let data  = {
      '_token':this.csrf,
      'email':this.email,
      'password':this.password
    };

    //Post
    let r = await ax.fetch('/login', data, 'post');

    //Catch errors
    if(!r){      
      if(ax.lastResponse.status == 422){
        this.errors = ax.lastResponse.data.errors;
        return;
      }
    }

    //Check signin
    await this.getUser();
    if(this.user.id != undefined) location.reload();

  }
},
}
</script>

<style scoped>
  .forgot-password {
      text-decoration: underline;
      color: #333;
      font-size: 16px;
  }
</style>