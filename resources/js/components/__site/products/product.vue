<template>
<div>
    <site-header />

    <main>
      <div class="container">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="/catalogue">Каталог</a></li>
            <li class="breadcrumb-item active">{{product.name}}</li>
          </ol>
        </nav>

        <div class="row product">
          <!-- Image -->
          <div class="col-md-6">
            <img 
              v-if="product.images != undefined && product.images[0] != undefined"            
              :src="product.images[0]" 
              style="    
                border-radius: 20px;
                width: 100%;
                height: auto;
              "
            >
          </div>

          <div class="col-md-6">
            <div class="product-info">

              <!-- Name -->
              <h1 class="title-page m-0 mb-sm-4">
                {{
                  product.name + 
                  (product.сountry ? ', '+product.сountry:'') + 
                  (product.unit_view ? ', '+product.unit_view:'')
                }}
              </h1>
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

              <!-- Ves -->
              <div class="product-weight">{{product.unit_view}} <span style="color:orange">??</span><!-- todo @@@--></div>

              <div class="row"> 
                <!-- КБЖУ -->
                <div v-if="product.calories" class="col-md-12 order-2 order-md-1 mt-4 mt-sm-0">                  
                  <div class="calories">
                    <div class="calories-header d-flex justify-content-between mb-4">
                      <span>БЖУ на 100гр продукта</span>
                      <span>Дневная норма<span style="color:orange">??</span><!-- todo @@@--></span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <!-- Ссal -->
                      <div class="calories-range">
                        <img src="/image/demo.png" alt="Демо кругового графика">
                        <div class="calories-range-text">{{product.calories}} <span>ккал</span></div>
                        <span style="color:orange">todo</span><!-- todo @@@-->
                      </div>
                      <!-- БЖУ -->
                      <div class="calories-scale">
                        <!-- Углеводы -->
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="product-line">
                            <div class="product-line-header d-flex justify-content-between mb-1">
                              <span>Углеводы</span>
                              <span class="bold">{{product.carbohydrates_fast}}г</span>
                            </div>
                            <div class="calories-scale-line"><div class="calories-scale-position yellow" :style="'width: '+product.carbohydrates_fast+'%;'"></div></div>
                          </div>
                          <div class="product-percent">40%<span style="color:orange">??</span><!-- todo @@@--></div>
                        </div>
                        <!-- Жиры -->
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="product-line">
                            <div class="product-line-header d-flex justify-content-between mb-1">
                              <span>Жиры</span>
                              <span class="bold">{{product.fats}}г</span>
                            </div>
                            <div class="calories-scale-line"><div class="calories-scale-position green" :style="'width: '+product.fats+'%;'"></div></div>
                          </div>
                          <div class="product-percent">70%<span style="color:orange">??</span><!-- todo @@@--></div>
                        </div>
                        <!-- Белки -->
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="product-line">
                            <div class="product-line-header d-flex justify-content-between mb-1">
                              <span>Белки</span>
                              <span class="bold">{{product.proteins}}г</span>
                            </div>
                            <div class="calories-scale-line"><div class="calories-scale-position blue" :style="'width: '+product.proteins+'%;'"></div></div>
                          </div>
                          <div class="product-percent">40%<span style="color:orange">??</span><!-- todo @@@--></div>
                        </div>
                      </div>                  
                    </div>
                  </div>
                </div>

                <!-- Price Cart Favorites -->
                <div class="col-md-12 order-1 order-md-2">
                  <!-- Price -->
                  <div class="d-flex align-items-center mb-4">                    
                    <template>
                      <span v-if="product.discount" class="product-price">
                        {{Number(product.discount.discount_price)}}р <span class="product-old-price">-{{Number(product.price)}}р</span>                        
                      </span>
                      <span v-else class="product-price">{{Number(product.price)}}р</span>
                    </template>
                  </div>

                  <div class="d-flex align-items-sm-center align-items-start justify-content-sm-between justify-content-between">

                    <!-- To Cart -->
                    <template>
                      <div v-if="getItem(product.id)" class="cart-counter product-counter mr-sm-4 mr-0">
                        <button @click="toCart(product.id, getItem(product.id).count-1)" class="back">-</button>
                        <input class="number" :value="getItem(product.id).count" type="text">
                        <button @click="toCart(product.id, getItem(product.id).count+1)" class="next">+</button>
                      </div>
                      <button v-else @click="toCart(product.id)" class="btn-yellow btn-thick btn-product mr-4">В корзину</button>
                    </template>

                    <!-- Gramm -->
                    <!-- <div>
                      <select class="product-select mr-4">
                        <option value="1000 гр">1000 гр</option>
                        <option value="500 гр">500 гр</option>
                        <option value="50 гр">50 гр</option>
                      </select>                    
                      
                    </div> -->
                    <!-- <span style="color:orange">todo</span>todo @@@ -->
      
                    <!-- Favorites -->
                    <button class="to-favorite">
                      <favorite-button :product-id="product.id"/>
                    </button>
                  </div>
                </div>
              </div> 

              <div class="product-text mt-5">
                <!-- Description -->
                <template v-if="product.description">
                  <h2 class="product-title">Описание</h2>
                  <span class="mb-3" v-html="product.description"></span>
                </template>
                <template v-if="product.composition">
                  <h2 class="product-title">Состав:</h2>
                  <span class="mb-3" v-html="product.composition"></span>
                </template>
                <template v-if="product.сountry">
                  <h2 class="product-title">Страна производитель:</h2>
                  <p class="mb-3">{{product.сountry}}</p>
                </template>
                <template v-if="product.benefit">              
                  <h2 class="product-title">Польза:</h2>
                  <span class="mb-3" v-html="product.benefit"></span>
                </template>
              </div>
            </div>
          </div>
        </div>

        <!-- <h2 class="product-title mb-4">С этим товаром покупают:</h2>
        <span style="color: orange;">todo</span> -->
         <!-- @@@ todo -->
        <!-- <div class="row">

          <div class="col-lg col-md-4 col-6">
            <div class="product-item">
              <a href="#!"><div class="product-item-img" style="background-image: url(image/picture.jpg);"></div></a>
              <div class="product-item-text">
                <div class="product-item-title">
                  <a href="#!">Яблоки сезонные</a>
                </div>
                <div class="product-item-cart">
                    <span>100р</span>
                    <button class="to-cart"><img src="image/cart.svg" alt="В корзину"></button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg col-md-4 col-6">
            <div class="product-item">
              <a href="#!"><div class="product-item-img" style="background-image: url(image/picture.jpg);"></div></a>
              <div class="product-item-text">
                <div class="product-item-title">
                  <a href="#!">Яблоки сезонные</a>
                </div>
                <div class="product-item-cart">
                    <span>100р</span>
                    <button class="to-cart"><img src="image/cart.svg" alt="В корзину"></button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg col-md-4 col-6">
            <div class="product-item">
              <a href="#!"><div class="product-item-img" style="background-image: url(image/picture.jpg);"></div></a>
              <div class="product-item-text">
                <div class="product-item-title">
                  <a href="#!">Яблоки сезонные</a>
                </div>
                <div class="product-item-cart">
                    <span>100р</span>
                    <button class="to-cart"><img src="image/cart.svg" alt="В корзину"></button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg col-md-4 col-6">
            <div class="product-item">
              <a href="#!"><div class="product-item-img" style="background-image: url(image/picture.jpg);"></div></a>
              <div class="product-item-text">
                <div class="product-item-title">
                  <a href="#!">Яблоки сезонные</a>
                </div>
                <div class="product-item-cart">
                    <span>100р</span>
                    <button class="to-cart"><img src="image/cart.svg" alt="В корзину"></button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg col-md-4 col-6">
            <div class="product-item">
              <a href="#!"><div class="product-item-img" style="background-image: url(image/picture.jpg);"></div></a>
              <div class="product-item-text">
                <div class="product-item-title">
                  <a href="#!">Яблоки сезонные</a>
                </div>
                <div class="product-item-cart">
                    <span>100р</span>
                    <button class="to-cart"><img src="image/cart.svg" alt="В корзину"></button>
                </div>
              </div>
            </div>
          </div>

        </div> -->
      </div>
    </main>
  
    <site-footer />
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    id:this.$route.params.id,
  }},
  computed:{
    ...mapGetters(
      {
        product:'product/getOne',
        cart:'cart/getCart'      
      }
    ),    
  }, 
  mounted(){
    this.fetchProduct(this.id);    
    this.getCart();
  },
  methods:{
    ...mapActions({
      'fetchProduct':'product/fetchOne',
      'getCart':'cart/fetch',
      'editItem':'cart/editItem',
    }),    
    toCart(id,count = 1){
      this.editItem({id,count});
    },
    getItem(id){
      if(this.cart.items == undefined) return false;
      return this.cart.items.find(x => x.product_id == id);
    }
  }
}
</script>

<style scoped>
  .catalog-item-icon img{
    height:30px;
    margin-right: 5px;
  }
</style>