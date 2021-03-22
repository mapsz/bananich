<template>
  <div class="juge-catalogue-item" :class="isX?'bananich-x':''">
    <!-- Image Container -->
    <div class="juge-catalogue-item-image-container">
      <div class="juge-catalogue-item-image" :style='"background-image:url(\""+product.mainImage+"\")"'>
        <a 
          :href="($route.path == '/profile/favorites' ? '' : $route.path) + ($route.path == '/' ? '':'/') + 'product/' + product.id"
          class="juge-catalogue-item-image-link"
        />
        <!-- Icons -->
        <template>
          <!-- Bonus -->
          <span v-if="!isX && (product.bonus == 1)" class="bonus-icon" style=""
            data-toggle="tooltip" title="Можно купить за бонусы"
          ></span>
          <!-- Notie Icons -->
          <product-noty-icons :product="product" :bonus="product.bonus == 1 && !isX? true : false"/>
        </template>
        <!-- More Info -->
        <div class="juge-catalogue-item-more-info" style="position: absolute;">
          <!-- Discounts -->
          <div v-if="!isX && (product.discount && product.discount.quantity >= 1)">
            <span>
              Скидка на 
              <template v-if="product.discount.quantity == 1">
                первую
              </template>
              <template v-else>
                первыe <b style="color: rgb(255, 92, 0)">{{product.discount.quantity}}</b>
              </template>
              ед.
            </span>
          </div>   
          <!-- Short info -->  
          <div v-if="product.short_info && product.short_info != ''">
            {{product.short_info}}
          </div>  
          <!-- Shelf Life -->  
          <!-- <div v-if="product.shelf_life && product.shelf_life != ''">
            {{product.shelf_life}}
          </div> -->
        </div>
        <!-- Not available -->
        <div v-if="notAloved" class="juge-catalogue-item-not-available" />
      </div>
    </div>
    <!-- Name -->
    <div class="juge-catalog-item-name-container">
      <a :href="($route.path == '/profile/favorites' ? '' : $route.path) + ($route.path == '/' ? '':'/') + 'product/' + product.id" >
        <div class="juge-catalog-item-name">
          {{
            product.name + 
            (product.unit_view ? ', '+product.unit_view : '')
          }}
        </div>
      </a>
    </div>
    <!-- БЖУ -->
    <div class="juge-catalog-item-cal-container">
      <div v-if="product.calories != undefined && product.calories > 0" class="catalog-item-cal">
        <template >
          <!-- Cal -->
          <template>
            <div class="catalog-item-cal-box">
              <span class="title">ккал</span>
              <span>{{product.calories != undefined ? product.calories : 0}}</span>
            </div>
            <div class="catalog-item-cal-hr"></div>
          </template>
          <!-- Белки -->
          <template >
            <div class="catalog-item-cal-box">
              <span class="title">белки</span>
              <span>{{product.proteins != undefined ? product.proteins : 0}}г</span>
            </div>
            <div class="catalog-item-cal-hr"></div>
          </template>
          <!-- Жиры -->
          <template >
            <div class="catalog-item-cal-box">
              <span class="title">жиры</span>
              <span>{{product.fats != undefined ? product.fats : 0}}г</span>
            </div>
            <div class="catalog-item-cal-hr"></div>
          </template>
          <!-- Углеводы -->
          <template >
            <div class="catalog-item-cal-box">
              <span class="title">углев.</span>
              <span>{{product.carbohydrates != undefined ? product.carbohydrates : 0}}г</span>
            </div>
          </template>
        </template>
      </div>
      <template v-else>
        <div v-if="product.сountry != undefined && product.сountry.length > 0" class="catalog-item-country">
          <div>Страна: <span style="color:black">{{product.сountry}}</span></div>
        </div>
      </template>
    </div>
    <!-- Price / Cart -->
    <div class="juge-price-cart-container">
      <!-- Price -->
      <div class="price">
        <!-- X bananich price -->
        <template v-if="isX">          
          <!-- With Discount -->
          <span v-if="product.final_price != product.final_price_x" class="sale">
            <!-- Regular price -->
            <span class="old">{{Number(product.final_price)}}р</span>
            <!-- Discount price -->
            <span ><b style="color: black;">{{Number(product.final_price_x)}}р</b></span>
          </span>
          <!-- No Discount -->
          <span v-else>{{Number(product.final_price_x)}}р</span>
        </template>
        <!-- Normal bananich price -->
        <template v-else >
          <!-- With Discount -->
          <span v-if="product.discount" class="sale">
            <!-- Regular price -->
            <span class="old">{{Number(product.price)}}р</span>
            <!-- Discount price -->
            <span ><b style="color: #EB5757;">{{Number(product.final_price)}}р</b></span>
          </span>
          <!-- No Discount -->
          <span v-else><b>{{Number(product.final_price)}}р</b></span>
        </template>
      </div>

      <!-- Add to cart -->
      <product-add-to-cart @notAloved="notAloved=true;" :product='product'/>

    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    isX:isX,
    count:0,
    notAloved:false,
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

<style>
  
  /* Item */
  .juge-catalogue-item{
    border:1px solid #d3d3d3;
    margin-bottom: 20px;
    border-radius: 10px;
  }

  /* Image */
  .juge-catalogue-item-image-container{
    border-radius: 10px;
    width: 100%;
    padding-top: 100%;
    position: relative;    
  }
  .juge-catalogue-item-image{
    border-radius: 10px;
    background-size: contain;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }
  .juge-catalogue-item-image-link{
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 0;    
  }

  /* Name */
  .juge-catalog-item-name-container{ 
    height: 40px;
    display: flex;
    align-items: center;
    margin:5px;
  }
  .juge-catalog-item-name{
    font-family: Open Sans;
    font-size: 12px;
    line-height: 115%;
    color: #000000;
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }

  /* БЖУ */
  .juge-catalog-item-cal-container{
    margin: 0 5px 5px;
    height: 30px;
  }
  .juge-catalog-item-cal-container .title{
    margin:0;
  }
  .juge-catalog-item-cal-container .catalog-item-cal-hr{
    height: inherit;
  }

  /* Country */
  .catalog-item-country{
    font-size: 11px;
    color: gray;
    height: 100%;
    display: flex;
    align-items: center;
  }
  
  /* Price Cart */
  .juge-price-cart-container{
    justify-content: space-between;
    margin: 0 5px;
    height: 45px;
    display: flex;
  }
  /* Price */
  .juge-price-cart-container .price{
    margin: 0 0 10px 5px;    
    font-size: 18px;
    line-height: 110%;
    display: flex;
    align-items: center;
  }
  .juge-price-cart-container .sale {
    display: flex;
    flex-direction: column;
    padding-bottom: 5px;
  }
  .juge-price-cart-container .old{
    text-decoration-line: line-through;
    font-size: 12px;
    color: #828282;
  }

  /* Bonus icon */
  .bonus-icon{
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fbe214;
    border: 1px solid rgb(95 84 0);
    color: black;
    display: flex;
    width:20px;
    height: 20px;
    border-radius: 20px;
    position: absolute;
    top: 3px;
    left: 3px;
    font-weight: 600;
    font-size: 10pt;
    line-height: 0.5;
  }
  .bonus-icon:after{
    content: "Б";
  }

  /* Icons */
  .juge-catalogue-item-image-container .catalog-item-icon {
    margin-bottom: 12px;
    display: flex;
    flex-direction: column;
    height: 100%;
    flex-wrap: wrap;
    width: fit-content;
  }
  .juge-catalogue-item-image-container .catalog-item-icon img{
    background-color: white;
    border-radius:50px;
    display: inline-block;
    height: 20px!important;
    width: 20px!important;
    margin: 3px 0px 0 3px;
  }

  /* More Info */
  .juge-catalogue-item-more-info{
    border-radius: 10px;
    font-size: 10px;
    line-height: 115%;
    padding:0px;
    position: absolute;
    top: -10px;
    margin-left: 50px;
    right: -5px;
    background-color: #fbe214d6;
  }
  .page-x .juge-catalogue-item-more-info{
    background-color:#8ac2a7d6;
  }  
  .juge-catalogue-item-more-info div {
    margin: 0 5px 5px 5px;
  }
  .juge-catalogue-item-more-info div:first-child {
    margin-top: 5px;
  }

  /* Not Available */
  .juge-catalogue-item-not-available{
    border-radius: 10px;
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    background: #000000a8;
    z-index: 9;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .juge-catalogue-item-not-available:after{
    content: "Данный товар не может быть заказан на выбранную дату закупки";
    color: white;
    margin: 10px;
  }
  
  /* Desktop */
  @media screen and (min-width: 992px){

      /* Name */
    .juge-catalog-item-name-container{ 
      height: 60px;
      margin: 10px;
    }
    .juge-catalog-item-name{
      font-size: 18px;
    }

    /* Country */
    .catalog-item-country{
      font-size: 14px;
    }
    /* БЖУ */
    .juge-catalog-item-cal-container {
      height: 42px;
      margin: 0 10px 10px 10px;
    }

    /* Price Cart */
    .juge-price-cart-container{
      margin: 0 10px 10px 10px;
    }

    /* Price */
    .juge-price-cart-container .price{
      font-size: 24px;
    }
    .juge-price-cart-container .old{
      font-size: 16px;
      margin-bottom: -7px;
    }    

    /* Bonus icon */
    .bonus-icon{
      width: 30px;
      height: 30px;
      left: 5px;
      top: 5px;
    }    
    /* Icons */
    .juge-catalogue-item-image-container .catalog-item-icon img{
      height: 30px!important;
      width: 30px!important;
      margin: 5px 0px 0 5px;
    }    

    /* More Info */
    .juge-catalogue-item-more-info{
      font-size: 13px;
      position: absolute;
      margin-left: 75px;
    }  

  } 

</style>