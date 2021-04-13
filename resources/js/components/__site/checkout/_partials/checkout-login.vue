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
      <div class="text-center" v-if="!isX">чтобы получить <b>10% кешбэк</b> с этой покупки</div>
      <div class="d-flex"  style="align-items: center;" v-else>
        <div class="text-center">
          Зарегистрируйтесь чтобы получить возможность оформить следующую доставку за 200 рублей
        </div>
        <div>
          <span @click="showRegisterMembershipInfo=true" data-v-2252815c="" class="ml-2 info-icon info-icon-sm info-icon-success" style="color: black;cursor:pointer;"></span>
        </div>
      </div>
    </div>
  </div>

  <!-- About no Container -->
  <x-popup :title="''" :active="showRegisterMembershipInfo" @close="showRegisterMembershipInfo=false" id="register-membership-info-modal">
    При оформлении доставки в течении двух недель с момента доставки, стоимость сервисно сбора  автоматически пересчитается и составит 200 рублей вместо 300.
  </x-popup> 
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{  
  isX:isX,
  showLogin: false,
  showLoginType: 'signup',  
  showRegisterMembershipInfo: false,
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