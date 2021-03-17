<template>
<div>
  <div v-for='(item,i) in cart.items' :key='i' class="filter-line">
    <div>
      <div class="cart-line-name">{{item.name}}</div>
      <div v-if="item.count > 0" class="cart-line-weight">x{{item.count}}</div>
    </div>
    <div class="cart-line-sum pl-2">
      {{isX ? item.final_price_x : item.final_price}}р
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  data(){return{  
    isX:isX,
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart'
    }),    
  },    

}
</script>

<style>

</style>