<template>
<div>
  <!-- Button -->
  <div v-if="buttons" class="mb-1 list-group list-group-horizontal">
    <span 
      @click="result=false;pre=true;"
      :class="pre ? 'list-group-item-primary font-weight-bold' : ''" 
      class="list-group-item list-group-item-action"
      style="cursor:pointer;text-align: center;"
    >
      Предварительно
    </span>
    <span 
      @click="result=true;pre=false;"
      :class="result ? 'list-group-item-primary font-weight-bold' : ''" 
      class="list-group-item list-group-item-action"
      style="cursor:pointer;text-align: center;"
    >
      Погружено
    </span>
  </div>  
  <!-- Common -->
  <div class="mb-2" style="border-top:2px dashed black;">
    <!-- Shipping -->
    <div class="d-flex justify-content-between border-bottom">            
      <span>Доставка:</span>
      <span>{{parseInt(order.shipping)}}</span>
    </div>
    <!-- Bonus -->
    <div class="d-flex justify-content-between border-bottom">            
      <span>Бонусы:</span>
      <span>{{parseInt(order.bonus)}}</span>
    </div>
    <!-- Coupons -->
    <div 
      v-for="coupon in order.coupons" :key="coupon.id"
      class="d-flex justify-content-between border-bottom"
    >            
      <span>Купон {{coupon.code}}:</span>
      <span>-{{parseInt(coupon.discount)}}</span>
    </div>
  </div> 
  <!-- Pre -->
  <div v-if="pre">
    <h5 v-if="!buttons && (pre && result)" class="m-0">Предварительно</h5>
    <div :class="!buttons ? 'mb-2' : ''" style="border-top:1px dashed black;">
      <!-- Subtotal -->
      <div v-if="order.items_subtotal != order.total" class="d-flex justify-content-between border-bottom">            
        <span>Подытог:</span>
        <span>{{parseInt(order.items_subtotal)}}</span>
      </div>   
      <!-- Discount -->
      <div v-if="order.discounts_total != 0" class="d-flex justify-content-between border-bottom">            
        <span>Скидки:</span>
        <span>{{parseInt(order.discounts_total)}}</span>
      </div>   
      <!-- Total -->
      <div class="d-flex justify-content-between border-bottom">            
        <span><b>Итог:</b></span>
        <span><b>{{parseInt(order.total)}}</b></span>
      </div>          
    </div> 
  </div>
  <!-- Result -->
  <div v-if="order.total_result > 0 && result">
    <h5 v-if="!buttons && (pre && result)" class="m-0">Погружено</h5>
    <div style="border-top:1px dashed black;">          
      <!-- Subtotal -->
      <div v-if="order.items_subtotal_result != order.total_result" class="d-flex justify-content-between border-bottom">            
        <span>Подытог:</span>
        <span>{{parseInt(order.items_subtotal_result)}}</span>
      </div>   
      <!-- Discount -->
      <div v-if="order.discounts_total_result != 0" class="d-flex justify-content-between border-bottom">            
        <span>Скидки:</span>
        <span>{{parseInt(order.discounts_total_result)}}</span>
      </div>   
      <!-- Total -->
      <div class="d-flex justify-content-between border-bottom">            
        <span><b>Итог:</b></span>
        <span><b>{{parseInt(order.total_result)}}</b></span>
      </div>           
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['order','buttons','show'],
  data(){return{
    pre:true,
    result:true,
  }},
  mounted(){
    if(this.buttons){
      this.pre = false;
      this.result = true;    
    }

    if(this.show != undefined){
      if(this.show == 'result'){
        this.pre = false;
        this.result = true;   
      }
      if(this.show == 'pre'){
        this.pre = true;
        this.result = false;   
      }
    }
  },
}
</script>

<style>

</style>