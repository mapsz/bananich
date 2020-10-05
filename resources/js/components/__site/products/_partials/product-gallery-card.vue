<template>
  <div class="catalog-item">
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
        <span v-if="product.bonus == 1" style="
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
        <product-add-to-cart :product='product'/>
      </div>
    </div>
  </div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
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
</style>