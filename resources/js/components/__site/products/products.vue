<template>
  <div>

    <site-header />

    <a name="catalogue"></a>
    <main class="home">
      <div class="container">
        <h1 class="title-h1"><span>Бананыч.</span> Доставка полезного</h1>

        <a v-if="showUp" href="#catalogue" style="
          position: fixed;
          z-index: 9999;
          right: 20px;
          bottom: 50px;
          border: 1px solid black;
          padding: 5px;
          border-radius: 10px;
          background-color: #fbe21485;
          color: black;
        ">Наверх ⇑</a>
        <div class="row content-page">
          

          <!-- Categories Sidebar -->
          <div class="col-lg-4">
            <categories-menu v-scroll="handleScroll" />
          </div>

          <div v-if="active || !isMobile" class="col-lg-8 d-sm-block" :class="currentCategory.id === false ? 'd-none' : ''">
            
            <div class="title-wrap title-page">
              <h2 class="title-h2">{{active.name}}</h2>
              <!-- Фильтр и сортировка -->
              <div class="filter">            
                <!-- Sort -->
                <product-sorts />
                <!-- Filters -->
                <product-filters />
              </div>
            </div>

            <!-- Product list -->
            <div v-if="768" class="row">

              <!-- Карточка товара -->
              <div v-for='(product,i) in products' :key='i' class="col-6 col-lg-4 ">
                <product-gallery-card :product="product" />
              </div>

              <span v-if="products.length < 1 && isFetched && !isWaterfalling"><b>Ничего не найдено</b></span>
              <div v-if="isWaterfalling || !isFetched" class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>

              <!-- <div 
                v-infinite-scroll="loadMore" 
                infinite-scroll-distance="10"
              ></div> -->

            </div>


              <div v-if="isFetched && !isWaterfalling">
                <product-not-found></product-not-found>
                
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
    showUp:false,
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
      isFetched:'product/isFetched',
      isWaterfalling:'product/isWaterfalling',
      active:'category/getActive',
    }), 
    isMobile:function(){return window.screen.width <= 768;},
    currentCategory:function(){
        if (this.categories[0] != undefined) {
          let cat =  this.categories.find(x => x.id == this.filters.category);
          if (cat != undefined) return cat;
          return  {id:0,name:''};
        }
        
       return {id:0,name:''};
    }
  },
  async mounted(){
    // this.getCart();
    this.fetchFavorites();
    await this.setWaterfall(1);
    if(!this.isMobile) this.fetch();
  },
  methods:{
    ...mapActions({
      'fetch':'product/fetchData',
      'addFilter':'product/addFilter',
      'setInfinite':'product/setInfinite',
      'setWaterfall':'product/setWaterfall',
      'addInfinite':'product/addInfinite',
      'getCart':'cart/fetch',
      'editItem':'cart/editItem',
      'fetchFavorites':'favorite/fetchData',
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
      await this.addInfinite();
      this.busy = false;
    },
    handleScroll: function (evt, el) {
      let position = window.scrollY;  

      if(position > 900)
        this.showUp = true;
      else
        this.showUp = false;
    }    
  }
}
</script>

<style scoped>


</style>