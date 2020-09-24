<template>


  <form class="cart-promo" @submit.prevent="add()">
    <input v-model="coupon" type="text" placeholder="Ввести промокод" class="cart-promo-input">
    <button type="submit" class="cart-promo-btn">Применить</button>
  </form>
  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    coupon:''
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
    }),
  },
  methods:{
    async add(){

      let r = ax.fetch('/coupon/cart' , {coupon:this.coupon},'put');

      
      console.log(this.coupon);
    }
  },

}
</script>

<style>

</style>