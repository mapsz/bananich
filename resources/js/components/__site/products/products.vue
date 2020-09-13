<template>
  <div>

    <site-header />

    <main class="home">
      <div class="container">
        <h1 class="title-h1"><span>Бананыч.</span> Доставка полезного</h1>

        <div class="row content-page">

          <!-- Categories Sidebar -->
          <categories-sidebar v-model="categoriesActive"/>

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
            <div v-if="width > 768 || categoriesActive" class="row">

              <!-- Карточка товара -->
              <div v-for='(product,i) in products' :key='i' class="col-6 col-lg-4 ">
                <product-gallery-card :product="product" />
              </div>

              <span v-if="products.length < 1"><b>Ничего не найдено</b></span>

              <div 
                v-infinite-scroll="loadMore" 
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
    busy:false,
    categoriesActive:false,
    width:window.screen.width,
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
    async loadMore(){
      if(this.busy) return;
      if(this.infinite >= this.pages.last_page) return;
      this.busy = true;
      console.log('busy');
      await this.addInfinite();
      this.busy = false;
      
      console.log('nobusy');
    }
  }
}
</script>

<style scoped>

  .catalog-item-icon img{
    margin-right:10px;
  }

</style>