<template>
  <div class="cart" v-click-outside="hide">

    <div class="d-block">
      

      <div class="d-flex" style="justify-content: space-between;">
        
        <!-- image -->
        <div >      
          <a href="/cart" class="d-flex">
            <img src="/image/cart.svg" alt="cart">
          </a>
        </div>

        <!-- info -->
        <div v-if="summ" class="cart-summ ml-2">
          <span style="font-size:16px;">{{currencySymbol+summ}}</span> 
          <span style="font-size:12px;font-weight: 400;" v-if="fullWeight" class="d-block">{{fullWeight.toFixed(2)}}кг</span>
        </div>

        <!-- Dropdown button -->
        <button 
          class="cart-arr ml-2"
          :class="cartDrop ? 'active' : ''"
          @click="cartDrop = !cartDrop"
        >
          <img src="/image/cart-arr.svg" alt="cart">
        </button>

      </div>

      <!-- Saved -->
      <div v-if="saved && isX" class="d-flex mt-1" style="font-size:14px">        
        <div style="display: inline-block;">
          <span @click="showSaved=true" data-v-2252815c="" class="info-icon info-icon-sm info-icon-success" style="color: black;cursor:pointer;"></span>
        </div>
        <span class="ml-1">Ваша экономия: </span>
        <span class="ml-1"><b>{{currencySymbol+saved}}</b></span>
      </div>
      
      <!-- About Saved -->
      <x-popup :title="''" :active="showSaved" @close="showSaved=false" id="about-saved-modal">
        <saved-text />
      </x-popup>  

    
    </div>



    <!-- Выпадающий список Корзина -->
    <div class="dropdown-sad cart-list" :style="cartDrop ? '' : 'display: none;' " style="position: absolute;">
      <div class="dropdown-arr" ></div>

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
    isX:isX,
    currencySymbol:currencySymbol,
    cartDrop:false,
    showSaved:false,
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      settings:'settings/beautyGet',
    }),    
    saved(){      
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.saved == undefined) return false;
      return this.cart.xData.saved;
    },
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
    fullWeight (){
      if(!this.cart || this.cart.xData == undefined || this.cart.xData.fullWeight == undefined) return false;
      return this.cart.xData.fullWeight;
    },
  }, 
  methods:{    
    hide(){this.cartDrop=false;},
  },  
}
</script>

<style scoped>
 .page-x .cart-summ{
   /* background: #8AC2A7; */
 }

 .cart-summ{
    /* background-color: #fbe214; */
    /* border-radius: 10px; */
    padding: 0 5px;
    line-height: 115%;    
    font-weight: 600;
    color: black;
    /* margin: -10px; */
    font-size: 14px;
    /* height: 24px; */
    /* padding-top: 2px; */
 }
</style>