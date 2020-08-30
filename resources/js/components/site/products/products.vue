<template>
  <div>

    <site-header />

    <main class="home">
      <div class="container">
        <h1 class="title-h1"><span>Бананыч.</span> Доставка полезного</h1>

        <div class="row content-page">

          <!-- Categories Sidebar -->
          <categories-sidebar />

          <div class="col-lg-8 d-sm-block" :class="currentCategory.id === false ? 'd-none' : ''">
            
            <div class="title-wrap title-page">
              <h2 class="title-h2">{{currentCategory.name}}</h2>
              <!-- Фильтр и сортировка -->
              <div class="filter">            
                <!-- Sort -->
                <product-sorts />
                <!-- Filters -->
                <product-filters />
              </div>
            </div>

            <!-- Product list -->
            <div class="row">

              <!-- Карточка товара -->
              <div v-for='(product,i) in products' :key='i' class="col-6 col-lg-4 ">
                <div class="catalog-item">
                  <!-- Image -->
                  <div 
                    class="catalog-item-img" 
                    :style='"background-image:url(\""+product.mainImage+"\")"'
                  > 
                    <!-- Favorite -->
                    <button class="like">
                      <svg display="none">
                        <symbol id="like" viewBox="0 0 23 20">
                          <path d="M21.1754 1.95726C19.9848 0.695126 18.3511 0 16.5749 0C15.2473 0 14.0314 0.410249 12.961 1.21926C12.4209 1.62762 11.9315 2.12723 11.5 2.71036C11.0687 2.1274 10.5791 1.62762 10.0388 1.21926C8.96858 0.410249 7.75271 0 6.42506 0C4.64889 0 3.01503 0.695126 1.82442 1.95726C0.648033 3.20464 0 4.90876 0 6.75591C0 8.65708 0.724892 10.3974 2.28119 12.2329C3.67342 13.8747 5.67437 15.5415 7.99153 17.4714C8.78275 18.1306 9.67961 18.8776 10.6109 19.6734C10.8569 19.8841 11.1726 20 11.5 20C11.8273 20 12.1431 19.8841 12.3888 19.6738C13.32 18.8778 14.2174 18.1304 15.009 17.4709C17.3258 15.5413 19.3268 13.8747 20.719 12.2327C22.2753 10.3974 23 8.65708 23 6.75574C23 4.90876 22.352 3.20464 21.1754 1.95726Z" />
                        </symbol>
                      </svg>
                      <svg class="like-icon">
                        <use xlink:href="#like"></use>
                      </svg>
                    </button>

                  </div>                  
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
                      <img v-if="product.no_gluten != undefined" src="image/no-gluten.svg" alt="no gluten">
                      <img v-if="product.no_sugar != undefined" src="image/no-sugar.svg" alt="no sugar">
                      <img v-if="product.no_egg != undefined" src="image/no-eggs.svg" alt="no eggs">
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
                        <button v-else @click="toCart(product.id)" class="to-cart"><img src="image/cart.svg" alt="В корзину"></button>
                      </template>
                    </div>
                  </div>
                </div>
              </div>

              <span v-if="products.length < 1"><b>Ничего не найдено</b></span>

              <div 
                v-infinite-scroll="loadMore" 
                infinite-scroll-disabled="busy"
                infinite-scroll-distance="10"
              ></div>

            </div>

          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <site-footer />

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
  }},
  computed:{
    ...mapGetters({
      products:'product/get',
      inputs:'product/getInputs',
      errors:'product/getErrors',
      cart:'cart/getCart',
      filters:'product/getFilters',
      categories:'category/get',      
      pages:'product/getPages',
      infinite:'product/getInfinite',
    }), 
    currentCategory:function(){
        if (this.categories[0] != undefined) {
          let cat =  this.categories.find(x => x.id == this.filters.category);
          if (cat != undefined) return cat;
          return  {id:0,name:''};
        }
        
       return {id:0,name:''};
    }
  },
  mounted(){
    this.getCart();
    this.setInfinite(1);
    this.fetch();
  },
  methods:{
    ...mapActions({
      'fetch':'product/fetchData',
      'addFilter':'product/addFilter',
      'setInfinite':'product/setInfinite',
      'addInfinite':'product/addInfinite',
      'getCart':'cart/fetch',
      'editItem':'cart/editItem',
    }),
    toCart(id,count = 1){
      this.editItem({id,count});
    },
    getItem(id){
      return this.cart.items.find(x => x.product_id == id);
    },
    loadMore(){
      if(this.infinite >= this.pages.last_page) return;
      this.addInfinite();
    }
  }
}
</script>

<style scoped>

  .catalog-item-icon img{
    margin-right:10px;
  }

</style>