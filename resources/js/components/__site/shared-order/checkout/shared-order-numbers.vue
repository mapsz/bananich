<template>
<div>

  <!-- Overweight -->
  <div v-if="cart != undefined && cart.xData != undefined && cart.xData.overWeightKg != undefined && cart.xData.overWeightKg > 0" class="cart-overweight">
    <div class="d-flex">
      <div>
        <span class="info-icon"></span>
      </div>
      <div class="ml-3">
        <div><b>Вес вашей закупки превышен на {{cart.xData.overWeightKg.toFixed(2)}} кг (+{{cart.xData.overWeightPrice}}р)</b></div>
        <div>*Для вашей закупки доступно {{cart.xData.maxFreeWeight.toFixed(2)}} кг на человека </div>
      </div>
    </div>
  </div>

  <div v-if="cart" class="shared-order-numbers mt-3">
    <h4>Информация о покупке</h4>

    <div v-if="cart">
      <div class="d-flex justify-content-between"><span>Товары ({{cart.items.length}} шт)</span><b>{{cart.pre_price_x}} p</b></div>
      <div class="d-flex justify-content-between" v-if="participation_price">
        <span>Сервисный взнос</span><b>{{participation_price}} p</b>
      </div>
      <div class="d-flex justify-content-between" v-if="personalAddress"><span>Доставка</span><b>{{personalAddress}} p</b></div>
      <div class="d-flex justify-content-between" v-if="fullWeight"><span>Общий вес</span><b>{{fullWeight}} кг</b></div>
      <div class="d-flex justify-content-between" v-if="overWeightPrice"><span>Доп. вес</span><b>{{overWeightPrice}} p</b></div>

      <div class="d-flex justify-content-between mt-3"><span><b>Общая сумма</b></span><b>{{final_summ_x}} p</b></div>
    </div>

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
      settings:   'settings/beautyGet',
    }),
    fullWeight (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.fullWeight == undefined) return false;
      return this.cart.xData.fullWeight;
    },
    participation_price (){
      if(this.$route.name != 'soloCheckout'){
        if(!this.cart || this.cart.xData == undefined || this.cart.xData.participation_price == undefined) return false;
        return this.cart.xData.participation_price;
      }else{
        if(this.settings == undefined || this.settings.x_order_price == undefined || !this.settings.x_order_price) return;
        return this.settings.x_order_price;
      }
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
    final_summ_x(){
      if(!this.cart || this.cart.final_summ_x == undefined) return false;
      let final_summ_x = this.cart.final_summ_x;
      if(this.$route.name == 'soloCheckout') final_summ_x += this.participation_price;
      return final_summ_x;
    }
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