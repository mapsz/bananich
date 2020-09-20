<template>
<div class="cart-info">
  <div class="cart-info-header">
    Информация о покупке
  </div>
  <ul class="cart-info-list">
    <li class="cart-info-item">
      <div class="cart-info-name">Товары ({{cart.items != undefined ? cart.items.length : 0}} шт)</div>
      <div class="cart-info-sum">{{cart.pre_price}} р</div>
    </li>
    <li v-if="cart.shipping > 0" class="cart-info-item">
      <div  class="cart-info-name">Доставка</div>
      <div class="cart-info-sum">{{cart.shipping}} р</div>
    </li>
    <!-- Bonus -->
    <li v-if="cart.bonus > 0" class="cart-info-item">
      <div  class="cart-info-name">Бонусы</div>
      <div class="cart-info-sum">{{cart.bonus-(cart.bonus*2)}} р</div>
    </li>
    <!-- <li class="cart-info-item">
      <div class="cart-info-name">Списанные бонусы</div>
      <div class="cart-info-sum">-230 Б</div>
    </li> -->
    <li @click="dropDiscount=!dropDiscount" :class="dropDiscount ? 'active' : ''" class="p-0 cart-info-item dropdown-item"> <!-- За открытие списка отвечает класс active -->
      <!-- <a href="#!" class="cart-info-name dropdown-btn">Скидка</a> -->
      <!-- <div class="cart-info-sum">-200р</div>
      <ul class="dropdown-list cart-info-dd-list">
        <li class="d-flex justify-content-between">
          <span>промокод</span>
          <span>-10 р</span>
        </li>
        <li class="d-flex justify-content-between">
          <span>томат</span>
          <span>-59 р</span>
        </li>
        <li class="d-flex justify-content-between">
          <span>бесплатная доставка</span>
          <span>-200 р</span>
        </li>
      </ul> -->
  </li>
  <li class="cart-info-end">
    <div>Общая сумма</div>
    <div>{{cart.final_summ}}р</div>
  </li>
  </ul>
</div>  
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  data(){return{  
    dropDiscount:false,
  }},
  computed:{
    ...mapGetters({cart:'cart/getCart'}), 
  },
}
</script>

<style>

</style>