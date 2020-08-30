<template>
<div>
  <div v-for='(item,i) in cart.items' :key='i' class="filter-line">
    <div>
      <div class="cart-line-name">{{item.name}}</div>
      <div class="cart-line-weight">{{item.count}}</div>
    </div>
    <div class="cart-line-sum pl-2">
      {{item.final_price}}р
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      cart:'cart/getCart'
    }),    
  },    

}
</script>

<style>

</style>