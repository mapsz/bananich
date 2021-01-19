<template>
<div v-if="cart" class="shared-order-numbers">
  <h4>Информация о покупке</h4>

  <div v-if="cart">
    <div class="d-flex justify-content-between"><span>Товары ({{cart.items.length}} шт)</span><b>{{cart.pre_price_x}} p</b></div>
    <div class="d-flex justify-content-between" v-if="participation_price"><span>Сервисный взнос</span><b>{{participation_price}} p</b></div>
    <div class="d-flex justify-content-between" v-if="personalAddress"><span>Доставка</span><b>{{personalAddress}} p</b></div>
    <div class="d-flex justify-content-between" v-if="fullWeight"><span>Общий вес</span><b>{{fullWeight}} кг</b></div>
    <div class="d-flex justify-content-between" v-if="overWeightPrice"><span>Доп. вес</span><b>{{overWeightPrice}} p</b></div>

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
    fullWeight (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.fullWeight == undefined) return false;
      return this.cart.xData.fullWeight;
    },
    participation_price (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.participation_price == undefined) return false;
      return this.cart.xData.participation_price;
    },
    overWeightPrice (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.overWeightPrice == undefined) return false;
      return this.cart.xData.overWeightPrice;
    },
    order_id (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.order_id == undefined) return false;
      return this.cart.xData.order_id;
    },
    personalAddress (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.personalAddress == undefined) return false;
      return this.cart.xData.personalAddress;
    },
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