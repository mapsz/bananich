<template>
  <div class="cart">
    <button class="cart-btn">
      <a href="/cart">
        <img src="/image/cart.svg" alt="cart">
        <div v-if="cart.items != undefined && cart.items.length > 0" class="cart-num">{{cart.pre_price}}</div>
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
      <div class="dropdown-arr"></div>

      <cart-list></cart-list>

      <div class="filter-line-end">
        <div class="cart-line-name">Всего:</div>
        <div class="cart-line-sum">{{cart.final_summ}}р</div>
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
  },   
}
</script>

<style>

</style>