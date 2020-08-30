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
            <div class="product-img" :style="'background-image: url('+product.images[0]+');'"></div>
          </div>

          <div class="col-md-6">
            <div class="product-info">

              <!-- Name -->
              <h1 class="title-page m-0 mb-sm-5">
                {{
                  product.name + 
                  (product.сountry ? ', '+product.сountry:'') + 
                  (product.unit_view ? ', '+product.unit_view:'')
                }}
              </h1>
              <!-- Ves -->
              <div class="product-weight">{{product.unit_view}} <span style="color:orange">??</span><!-- todo @@@--></div>

              <div class="row"> 
                <!-- КБЖУ -->
                <div class="col-md-12 order-2 order-md-1 mt-4 mt-sm-0">                  
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
                    <div>
                      <select class="product-select mr-4">
                        <option value="1000 гр">1000 гр</option>
                        <option value="500 гр">500 гр</option>
                        <option value="50 гр">50 гр</option>
                      </select>                    
                      <span style="color:orange">todo</span><!-- todo @@@-->
                    </div>
      
                    <!-- Favorites -->
                    <button class="to-favorite">
                      <svg display="none">
                      <symbol id="like" viewBox="0 0 23 20">
                      <path d="M21.1754 1.95726C19.9848 0.695126 18.3511 0 16.5749 0C15.2473 0 14.0314 0.410249 12.961 1.21926C12.4209 1.62762 11.9315 2.12723 11.5 2.71036C11.0687 2.1274 10.5791 1.62762 10.0388 1.21926C8.96858 0.410249 7.75271 0 6.42506 0C4.64889 0 3.01503 0.695126 1.82442 1.95726C0.648033 3.20464 0 4.90876 0 6.75591C0 8.65708 0.724892 10.3974 2.28119 12.2329C3.67342 13.8747 5.67437 15.5415 7.99153 17.4714C8.78275 18.1306 9.67961 18.8776 10.6109 19.6734C10.8569 19.8841 11.1726 20 11.5 20C11.8273 20 12.1431 19.8841 12.3888 19.6738C13.32 18.8778 14.2174 18.1304 15.009 17.4709C17.3258 15.5413 19.3268 13.8747 20.719 12.2327C22.2753 10.3974 23 8.65708 23 6.75574C23 4.90876 22.352 3.20464 21.1754 1.95726Z"></path>
                      </symbol>
                      </svg>
                      <svg class="like-icon active"> <!-- Класс active добавляется при клике -->
                      <use xlink:href="#like"></use>
                      </svg>
                    </button>
                  </div>
                </div>
              </div> 

              <div class="product-text mt-5">
                
                <template v-if="product.description">
                  <h2 class="product-title">Описание</h2>
                  <p class="mb-3">{{product.description}}</p>
                </template>
                <template v-if="product.composition">
                  <h2 class="product-title">Состав:</h2>
                  <p class="mb-3">{{product.composition}}</p>
                </template>
                <template v-if="product.сountry">
                  <h2 class="product-title">Страна производитель:</h2>
                  <p class="mb-3">{{product.сountry}}</p>
                </template>
                <template v-if="product.benefit">              
                  <h2 class="product-title">Польза:</h2>
                  <p>{{product.benefit}}</p>
                </template>
              </div>
            </div>
          </div>
        </div>

        <h2 class="product-title mb-4">С этим товаром покупают:</h2>
        <span style="color: orange;">todo</span> <!-- @@@ todo -->
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
      return this.cart.items.find(x => x.product_id == id);
    }
  }
}
</script>

<style>

</style>