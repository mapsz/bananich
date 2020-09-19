<template>
  <div class="catalog-item">
    <!-- Image -->
    <div>
      <div 
        class="catalog-item-img" 
        :style='"background-image:url(\""+product.mainImage+"\")"'
      > 
        <a
          :href="'/'.$route.fullPath+'/product/'+product.id" 
          style="position:absolute; width:100%; height:100%"          
        ></a>
        <!-- Bonus -->
        <span v-if="product.bonus" style="
          background-color: #fbe214;
          color: black;
          padding: 10px;
          border-radius: 20px;
          position: absolute;
          top: 10px;
          left: 10px;
          font-weight: 600;
          font-size: 12pt;
          line-height: 0.5;"
          data-toggle="tooltip" title="Можно купить за бонусы"
        >Б</span>
        <!-- Favorite -->
        <button  class="like">
          <favorite-button :product-id="product.id"/>
        </button>
      </div>  
    </div>
    <div class="catalog-item-text">
      <!-- Name -->
      <div class="catalog-item-title">
        <router-link :to="$route.fullPath+'/product/'+product.id">
          {{
            product.name + 
            (product.сountry ? ', '+product.сountry:'') + 
            (product.unit_view ? ', '+product.unit_view:'')
          }}
        </router-link>
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
        <template v-if="product.carbohydrates != undefined">
          <div class="catalog-item-cal-box">
            <span class="title">углев.</span>
            <span>{{product.carbohydrates}}г</span>
          </div>
        </template>
      </div>
      <!-- Icons -->
      <product-noty-icons :product="product" />
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
  mounted(){ 
    //
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
</style>