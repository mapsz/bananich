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
        <div>*Максимальный бесплатный вес заказа {{cart.xData.maxFreeWeight.toFixed(2)}}кг</div>
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
      <div class="d-flex justify-content-between" v-if="fullWeight"><span>Общий вес</span><b>{{fullWeight.toFixed(2)}} кг</b></div>
      <div class="d-flex justify-content-between" v-if="overWeightPrice"><span>Доп. вес</span><b>{{overWeightPrice}} p</b></div>   
      <!-- Container -->
      <template v-if="cart.container != undefined && cart.container.final_price != undefined && cart.container.final_price > 0">
        <div class="d-flex justify-content-between">
          <span>{{cart.container.name}}</span>
          <b>{{cart.container.final_price}} p</b>
        </div>
      </template> 
      <!-- Coupon -->
      <div v-if="cart.coupon != undefined" class="d-flex justify-content-between">
        <span>{{cart.coupon.code}}</span>
        <b>{{cart.coupon.discount-(cart.coupon.discount*2)}} р</b>
      </div>

      <!-- Saved -->
      <div v-if="saved > 0"class="d-flex justify-content-between mt-3">
        <span><b>ВАША ЭКОНОМИЯ</b>
        </span><b>{{saved}} p</b>
      </div>
      <!-- Final summ -->
      <div class="d-flex justify-content-between mt-3">
        <span><b>Общая сумма</b>
        </span><b>{{final_summ_x}} p</b>
      </div>
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
      checkout: 'checkout/get',
      order:'sharedOrder/getOrder',
      settings:   'settings/beautyGet',
    }), 
    saved(){      
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.saved == undefined) return false;
      return this.cart.xData.saved;
    },
    fullWeight (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.fullWeight == undefined) return false;
      return this.cart.xData.fullWeight;
    },
    participation_price (){
      if(this.$route.name != 'soloCheckout'){
        if(!this.cart || this.cart.xData == undefined || this.cart.xData.participation_price == undefined) return false;
        return this.cart.xData.participation_price;
      }else{
        if(!this.checkout || this.checkout.x_price_from_date == undefined) return false;
        return this.checkout.x_price_from_date;
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
      return this.cart.final_summ_x + (this.$route.name == 'soloCheckout' ? this.participation_price : 0);
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