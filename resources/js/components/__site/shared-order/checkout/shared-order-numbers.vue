<template>
<div class="shared-order-numbers">
  <h4>Информация о покупке</h4>

  <div v-if="cart">
    <div class="d-flex justify-content-between"><span>Товары ({{cart.items.length}} шт)</span><b>{{cart.final_summ_x}} p</b></div>
    <div class="d-flex justify-content-between"><span>Сервисный взнос</span><b>todo p</b></div>
    <div class="d-flex justify-content-between"><span>Общий вес</span><b>{{cart.weight}} кг</b></div>
    <div class="d-flex justify-content-between"><span>Доп. вес</span><b>{{0}} p</b></div>

    <div class="d-flex justify-content-between mt-3"><span><b>Общая сумма</b></span><b>{{cart.final_summ_x}} p</b></div>
  </div>

</div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      order:'sharedOrder/getOrder',
    }),
  },
}
</script>

<style scoped>
.shared-order-numbers{
  padding: 20px;
  background: #e7dfdc;
  border-radius: 10px;
}

</style>