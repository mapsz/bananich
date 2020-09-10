<template>
<div>
  <div class="checkout-title">Ваши данные</div>
  <div class="checkout-form" action="">

    <!-- Pre data -->
    <template>
      <div class="form-group"> 
        <div class="form-content bold" :class="!edit ? 'active' : ''">{{user.name}}</div>
        <input v-model="name" id="name" class="form-input form-input-show" :class="edit ? 'active' : ''" placeholder="Ваше имя" type="text">
      </div>

      <div class="form-group">
        <div class="form-content"  :class="!edit ? 'active' : ''">{{user.phone}}</div>
        <input v-model="phone" id="phone" class="form-input form-input-show" :class="edit ? 'active' : ''" placeholder="Ваш телефон" type="text">
      </div>

      <div class="form-group">
        <div class="form-content" :class="!edit ? 'active' : ''">{{user.email}}</div>
        <input v-model="email" id="email" class="form-input form-input-show" :class="edit ? 'active' : ''" placeholder="Ваш e-mail" type="text">
      </div>
    </template>

    <!-- Login -->
    <login-modal v-if="!user" :p-show="showLogin" :p-show-type="showLoginType" @close="showLogin=false"></login-modal>
    <div v-if="!user" class="form-button">
      <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <button @click="showLoginModal('signup')" class="btn-signup">Зарегистрироваться</button>
          <span>или</span>
          <button @click="showLoginModal('signin')" class="btn-signup">Войти</button>
        </div>
        <div class="text-center">чтобы получить <b>10% кешбэк</b> с этой покупки</div>
      </div>
    </div>

    <!-- Edit data -->
    <div v-if="user && edit==false" class="form-button">      
      <button @click="edit=true" class="form-url" >Это не мои данные</button>
    </div>
    
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
model: {event: 'blur'},
data(){return{
  name:'',
  phone:'',
  email:'',
  edit: false,
  showLogin: false,
  showLoginType: 'signup',
}},
computed:{
  ...mapGetters({user:'user/get'}),
},
watch: {
  name: function(){this.$emit('blur', {name:this.name, phone:this.phone, email:this.email});},
  phone: function(){this.$emit('blur', {name:this.name, phone:this.phone, email:this.email});},
  email: function(){this.$emit('blur', {name:this.name, phone:this.phone, email:this.email});},
  user: function(){
    if(this.isPreData()) this.edit = false;
    else this.edit = true;
  },
},
async mounted(){
},
methods:{
  ...mapActions({'getUser':'user/fetch'}),
  showLoginModal(type){
    this.showLoginType=type;    
    this.showLogin=true;
  },
  isPreData(){
    if(this.user.name && this.user.surname && this.user.email) return true;
    
    return false;
  }
},
}
</script>

<style>
.btn-signup {
    text-decoration: underline;
}
</style>