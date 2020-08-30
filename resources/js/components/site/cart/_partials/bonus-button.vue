<template>
  <div class="d-flex">    
    <div class="cart-bonuse-ico">
      <img src="image/icons/gift.svg" alt="Bonuse">
    </div>
    <a v-if="cart.presents[0] == undefined" href="/presents" class="url mt-2 mt-sm-3">Выбери свой подарок</a>    
    <div v-if="cart.presents[0] != undefined" class="checkout-info-text">У вас есть подарок!</div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  computed:{
    ...mapGetters({cart:'cart/getCart'}), 
  },

}
</script>

<style>

</style>