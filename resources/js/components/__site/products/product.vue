<template>
<div>
    <site-header />


    <main>
      <div class="container">
        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Каталог</a></li>
            <li v-if="parentCategory.id > 0" class="breadcrumb-item"><a :href="'/category/'+parentCategory.id">{{parentCategory.name}}</a></li>
            <li v-if="currentCategory.id > 0" class="breadcrumb-item"><a :href="'/category/'+currentCategory.id">{{currentCategory.name}}</a></li>
            <li class="breadcrumb-item active">{{product.name}}</li>
          </ol>
        </nav>

        <div class="row product" style="margin-bottom: 40px;">
          <!-- Image -->
          <div class="col-md-6">
            <img    
              :src="product.productImage" 
              style="    
                border-radius: 20px;
                width: 100%;
                height: auto;
              "
            >
          </div>

          <div v-show="product.name != undefined" class="col-md-6">
            <div class="product-info">

              <!-- Name -->
              <h1 class="title-page my-4">
                {{
                  product.name + 
                  (product.unit_view ? ', '+product.unit_view:'')
                }}
              </h1>
              <!-- Icons -->
              <product-noty-icons :product="product" />            

              <!-- Price Cart Favorites -->
              <div class="row"> 
                
                <div class="col-md-12 order-1 order-md-2">
                  <div class="d-flex justify-content-between">

                    <!-- Price -->
                    <div class="d-flex align-items-center">                    
                      <template>
                        <span v-if="product.discount" class="product-price">
                          {{Number(product.discount.discount_price)}}р <span class="product-old-price">-{{Number(product.price)}}р</span>                        
                        </span>
                        <span v-else class="product-price">{{Number(product.price)}}р</span>
                      </template>
                    </div>

                    <!-- To Cart -->
                    <product-add-to-cart class="to-cart-block" :product='product'/>

                    <!-- Left -->
                    <span v-if="this.product.available_unit <= 5 && this.product.always_publish == undefined">
                      {{this.product.available_unit}} ед. на складе
                    </span>
      
                    <!-- Favorites -->
                    <button >
                      <favorite-button :product-id="product.id"/>
                    </button>

                  </div>
                </div>
              </div> 

              <!-- Charts -->
              <div class="row"> 
                <product-charts />
              </div>



              <!-- More info -->
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


              <!-- To Cart -->
              <div v-if="isMobile" class="d-flex justify-content-center mt-4">
                <product-add-to-cart class="to-cart-block" :product='product'/>
              </div>

            </div>
          </div>
        </div>
      </div>
    </main>
  
    <site-footer />
</div>
</template>

<script>


    
// window.myChart = new Chart(ctx);

import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    id:this.$route.params.id,
  }},
  computed:{
    isMobile:function(){return window.screen.width <= 768;},
    ...mapGetters(
      {
        categories:'category/getAll',
        product:'product/getOne',
        cart:'cart/getCart'      
      }
    ), 
    currentCategory:function(){
      if (this.$route.params.catId == undefined) return false;
      if (this.categories[0] == undefined) return false;
      return this.categories.find(x => x.id == this.$route.params.catId);
    },
    parentCategory:function(){
      if (this.$route.params.parent_cat_id == undefined) return {'id':0,'name':''};
      if (this.categories[0] == undefined) return {'id':0,'name':''};
      return this.categories.find(x => x.id == this.$route.params.parent_cat_id);
    }
  }, 
  async mounted(){
    await this.fetchProduct(this.id);    
    await this.getCart();
    await this.fetchCategories();

  },
  methods:{
    ...mapActions({
      'fetchProduct':'product/fetchOne',
      'getCart':'cart/fetch',
      'editItem':'cart/editItem',
      'fetchCategories':'category/fetch',
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

<style >
  .to-cart-block .to-cart-big{
    display:block !important;
  }
  .to-cart-block .to-cart{
    display:none !important;
  }
</style>