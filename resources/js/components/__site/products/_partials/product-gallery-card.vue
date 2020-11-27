<template>
  <div class="catalog-item" :class="isX?'bananich-x':''">
    <!-- Image -->
    <div>
      <div 
        class="catalog-item-img" 
        :style='"background-image:url(\""+product.mainImage+"\")"'
      > 
        <a        
          :href="($route.path == '/profile/favorites' ? '' : $route.path) + ($route.path == '/'  ? '':'/') + 'product/' + product.id" 
          style="position:absolute; width:100%; height:100%"          
        ></a>
        <!-- Bonus -->
        <span v-if="!isX && (product.bonus == 1)" style="
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
        <a :href="($route.path == '/profile/favorites' ? '' : $route.path) + ($route.path == '/' ? '':'/') + 'product/' + product.id" >
          {{
            product.name + 
            (product.unit_view ? ', '+product.unit_view:'')
          }}
        </a>
      </div>
      <!-- БЖУ -->
      <div class="catalog-item-cal">
        <template v-if="product.calories != undefined && product.calories > 0">
          <!-- Cal -->
          <template>
            <div class="catalog-item-cal-box">
              <span class="title">ккал</span>
              <span>{{product.calories != undefined ? product.calories : 0}}</span>
            </div>
            <div class="catalog-item-cal-hr"></div>
          </template>
          <!-- Белки -->
          <template v-if="product.proteins != undefined">
            <div class="catalog-item-cal-box">
              <span class="title">белки</span>
              <span>{{product.proteins != undefined ? product.proteins : 0}}г</span>
            </div>
            <div class="catalog-item-cal-hr"></div>
          </template>
          <!-- Жиры -->
          <template v-if="product.fats != undefined">
            <div class="catalog-item-cal-box">
              <span class="title">жиры</span>
              <span>{{product.fats != undefined ? product.fats : 0}}г</span>
            </div>
            <div class="catalog-item-cal-hr"></div>
          </template>
          <!-- Углеводы -->
          <template v-if="product.carbohydrates != undefined">
            <div class="catalog-item-cal-box">
              <span class="title">углев.</span>
              <span>{{product.carbohydrates != undefined ? product.carbohydrates : 0}}г</span>
            </div>
          </template>
        </template>
      </div>
      <!-- Icons -->
      <product-noty-icons :product="product" />
      <!-- Price/Cart -->
      <div class="catalog-item-cart">
        <!-- Price -->
        <template>          
          <!-- Normal bananich price -->
          <template v-if="isX">
            <span>{{Number(product.price_x)}}р</span>
          </template>
          <!-- X bananich price -->
          <template v-else>            
            <span v-if="product.discount" class="sale">
              {{Number(product.discount.discount_price)}}р <span class="old">-{{Number(product.price)}}р</span>                        
            </span>
            <span v-else>{{Number(product.price)}}р</span>
          </template>
        </template>

        <!-- To Cart -->
        <product-add-to-cart :product='product'/>
      </div>
      <!-- Discount annonce -->  
      <div v-if="!isX && (product.discount && product.discount.quantity >= 1)" style="
        font-size: 9pt;
        font-style: italic;
        color: rgb(255, 92, 0);
        margin: 0 -10px;
      ">*Скидка на {{product.discount.quantity == 1 ? 'первую' : 'первыe'}} <b style="color: rgb(255, 92, 0)">{{product.discount.quantity}}</b> ед.</div>
      <!-- Short info -->  
      <div v-if="product.short_info && product.short_info != ''" style="
        font-size: 9pt;
        font-style: italic;
        color: color: rgb(255 184 0);
        margin: 0 -10px;
      ">*{{product.short_info}}</div>
    </div>
  </div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    isX:isX,
    count:0,
  }},
  props: ['product'],
  watch: {
    count: function(){
      this.count = this.getItem(id);
    },
  },
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
    }), 
    path: function(){
      return this.$route.path;
    },
  },
  mounted(){ 
    //
  },
  methods:{
    ...mapActions({
      'editItem':'cart/editItem',
    }),
  },
}
</script>

<style scoped>

.catalog-item-img{
  height: 233px !important;
}

@media (max-width: 580px){
  .catalog-item-img {
    height: 140px  !important;
  }
}

.bananich-x .catalog-item-text{
  background-color: #ffeded;
}
</style>