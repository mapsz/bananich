<template>
  <div class="cart" v-click-outside="hide">
    <button class="cart-btn">
      <a href="/cart">
        <img src="/image/cart.svg" alt="cart">
        <div v-if="summ" class="cart-num">{{summ}}р</div>
      </a>
    </button>
    <div class="cart-sum"></div>
    <button 
      class="cart-arr"
      :class="cartDrop ? 'active' : ''"
      @click="cartDrop = !cartDrop"
    >
      <img src="/image/cart-arr.svg" alt="cart">
    </button>

    <!-- Выпадающий список Корзина -->
    <div class="dropdown-sad cart-list" :style="cartDrop ? '' : 'display: none;' " style="position: absolute;">
      <div class="dropdown-arr" ></div>

      <cart-list></cart-list>

      <div class="filter-line-end">
        <div class="cart-line-name">Всего:</div>
        <div class="cart-line-sum">{{summ}}р</div>
      </div>

      <a href="/cart"><button class="btn-yellow btn-think">Оформить заказ</button></a>
    </div>
    <!-- Выпадающий список Корзина -->
    
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{  
      cartDrop:false,
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      settings:'settings/beautyGet',
    }),
    summ(){
      if(this.cart == undefined) return false;

      if(this.cart.type != undefined && this.cart.type == 2){
        if(this.cart.pre_price_x == undefined) return false;
        return this.cart.pre_price_x;
      }else{
        if(this.cart.pre_price == undefined) return false;
        return this.cart.pre_price;
      }
    }, 
  }, 
  methods:{    
    hide(){this.cartDrop=false;},
  },  
}
</script>

<style scoped>
 .page-x .cart-num{
   background: #8AC2A7;
 }
</style>