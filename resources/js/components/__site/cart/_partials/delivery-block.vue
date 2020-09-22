<template>  
  <div class="cart-delivery">                  
    <div class="cart-delivery-header d-flex justify-content-between">
      <span>Доставка</span>
      <template>
        <span v-if="(freeShipping - pre_price) > 0">200р</span>
        <span v-else>Бесплатно</span>
      </template>
    </div>                  
    <div v-if="(freeShipping - pre_price) > 0" class="d-flex">
      <div class="cart-delivery-ico"><img src="image/icons/free.svg" alt="Free"></div>
      <div class="cart-delivery-text">До бесплатной доставки закажите еще на <span>{{freeShipping - pre_price}}</span><br><a href="/catalogue" class="url">Докупить</a></div>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {

  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      settings:'settings/beautyGet',
    }),
    freeShipping: function(){
      return parseInt(this.settings.free_shipping);     
    },
    pre_price:function(){
      if(this.cart.pre_price == undefined) return 0;
      else this.cart.pre_price;
    }
  },
  mounted(){
    this.getSettings();
  },
  methods:{
   ...mapActions({'getSettings':'settings/fetch',}),  
  }
}
</script>

<style>

</style>