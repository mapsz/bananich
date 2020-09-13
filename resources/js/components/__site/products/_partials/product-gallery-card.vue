<template>
  <div class="catalog-item">
    <!-- Image -->
    <a :href="'/product/'+product.id">
      <div 
        class="catalog-item-img" 
        :style='"background-image:url(\""+product.mainImage+"\")"'
      > 
        <!-- Favorite -->
        <button  class="like">
          <favorite-button :product-id="product.id"/>
        </button>
      </div>  
    </a>                
    <div class="catalog-item-text">
      <!-- Name -->
      <div class="catalog-item-title">
        <a :href="'/product/'+product.id">
          {{
            product.name + 
            (product.сountry ? ', '+product.сountry:'') + 
            (product.unit_view ? ', '+product.unit_view:'')
          }}
        </a>
      </div>
      <!-- БЖУ -->
      <div class="catalog-item-cal">
        <!-- Cal -->
        <template v-if="product.calories != undefined">
          <div class="catalog-item-cal-box">
            <span class="title">ккал</span>
            <span>{{product.calories}}</span>
          </div>
          <div class="catalog-item-cal-hr"></div>
        </template>
        <!-- Белки -->
        <template v-if="product.proteins != undefined">
          <div class="catalog-item-cal-box">
            <span class="title">белки</span>
            <span>{{product.proteins}}г</span>
          </div>
          <div class="catalog-item-cal-hr"></div>
        </template>
        <!-- Жиры -->
        <template v-if="product.fats != undefined">
          <div class="catalog-item-cal-box">
            <span class="title">жиры</span>
            <span>{{product.fats}}г</span>
          </div>
          <div class="catalog-item-cal-hr"></div>
        </template>
        <!-- Углеводы -->
        <template v-if="product.carbohydrates_slow != undefined">
          <div class="catalog-item-cal-box">
            <span class="title">углев.</span>
            <span>{{product.carbohydrates_slow}}</span>
          </div>
        </template>
      </div>
      <!-- Icons -->
      <div class="catalog-item-icon d-flex">
        <img v-if="product.no_lactose != undefined" src="/image/no-lactose.svg" alt="no lactose">
        <img v-if="product.no_gluten != undefined" src="/image/no-gluten.svg" alt="no gluten">
        <img v-if="product.no_sugar != undefined" src="/image/no-sugar.svg" alt="no sugar">
        <img v-if="product.no_egg != undefined" src="/image/no-eggs.svg" alt="no eggs">
        <img v-if="product.no_heat != undefined" src="/image/no-heat.svg" alt="no heat">
        <img v-if="product.low_glycemic != undefined" src="/image/low-glycemic.svg" alt="low glycemic">
        <img v-if="product.no_milk != undefined" src="/image/no-milk.svg" alt="no milk">
        <img v-if="product.eco != undefined" src="/image/eco.svg" alt="eco">
      </div>
      <!-- Price/Cart -->
      <div class="catalog-item-cart">
        <!-- Price -->
        <template>
          <span v-if="product.discount" class="sale">
            {{Number(product.discount.discount_price)}}р <span class="old">-{{Number(product.price)}}р</span>                        
          </span>
          <span v-else>{{Number(product.price)}}р</span>
        </template>
        <!-- To Cart -->
        <template>
          <div v-if="getItem(product.id)" class="to-cart-number">
            <button @click="toCart(product.id, getItem(product.id).count-1)" class="back">-</button>
            <input class="number" :value="getItem(product.id).count" type="text">
            <button @click="toCart(product.id, getItem(product.id).count+1)" class="next">+</button>
          </div>
          <button v-else @click="toCart(product.id)" class="to-cart"><img src="/image/cart.svg" alt="В корзину"></button>
        </template>
      </div>
    </div>
  </div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  props: ['product'],
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
    }), 
  },
  methods:{
    ...mapActions({
      'editItem':'cart/editItem',
    }),
    toCart(id,count = 1){
      this.editItem({id,count});
    },
    getItem(id){
      if(this.cart == undefined) return false;
      if(this.cart.items == undefined) return false;
      return this.cart.items.find(x => x.product_id == id);
    },
  },
}
</script>

<style scoped>
  .catalog-item-icon img{
    height:30px;
    margin-right: 5px;
  }
</style>