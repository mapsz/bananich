<template>
<div v-if="!user" class="checkout-form">
  <!-- Login -->
  <login-modal :p-show="showLogin" :p-show-type="showLoginType" @close="showLogin=false"></login-modal>
  <div class="form-button">
    <div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <button @click="showLoginModal('signup')" class="btn-signup">Зарегистрироваться</button>
        <span>или</span>
        <button @click="showLoginModal('signin')" class="btn-signup">Войти</button>
      </div>
      <div class="text-center">чтобы получить <b>10% кешбэк</b> с этой покупки</div>
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{  
  showLogin: false,
  showLoginType: 'signup',  
}},
computed:{
  ...mapGetters({user:'user/get',cart:'cart/getCart'}),
},
methods:{  
  showLoginModal(type){
    this.showLoginType=type;    
    this.showLogin=true;
  },
},
}
</script>

<style>

</style>