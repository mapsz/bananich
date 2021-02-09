<template>
<juge-main :class="halloween?'halloween':''">
  
  <!-- Catalogue -->
  <a name="catalogue"></a>
  <main class="home">
    <div class="container">
      <!-- breadcrumb-sads -->
      <nav v-if="$route.path != '/'" aria-label="breadcrumb-sad">
        <ol class="breadcrumb-sad">
          <li class="breadcrumb-sad-item"><a href="/">Каталог</a></li>
          <li v-if="parentCategory.id > 0" class="breadcrumb-sad-item"><a :href="'/category/'+parentCategory.id">{{parentCategory.name}}</a></li>
          <li v-if="currentCategory.id > 0" class="breadcrumb-sad-item active">{{currentCategory.name}}</li>
        </ol>
      </nav>

      <!-- Header -->
      <h1 v-if="!isMobile || $route.path == '/'" class="title-h1">
        <template v-if="isX">
          <div class="moto">
            <b>NEOLAVKA</b> - это продукты по закупочным ценам с оплатой только фиксированной суммы сервисного сбора (включает доставку)
          </div>            
        </template>
        <template v-else>
          <span>ЭКОдоставка</span> 
          по выгодным ценам
        </template>
      </h1>

      <!-- To top -->
      <a v-if="showUp" href="#catalogue" 
        :style="isX ? 'background-color: rgb(138 194 167);' : 'background-color: #fbe21485;'"
        style="
          position: fixed;
          z-index: 9999;
          right: 20px;
          bottom: 50px;
          border: 1px solid black;
          padding: 5px;
          border-radius: 10px;
          color: black;
      ">Наверх ⇑</a>
      <div class="row content-page">          


        <!-- Desktop menu -->
        <div v-if="!isMobile" class="col-lg-4">
          <categories-menu v-scroll="handleScroll" />
        </div>

        <div  class="col-12 col-lg-8 d-sm-block product-list-wrapper" :class="currentCategory.id === false ? 'd-none' : ''">
          
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

          <!-- Moblie menu -->
          <categories-menu-mobile v-if="isMobile" />

          <!-- Product list -->
          <div class="row" v-if="!isMobile || active || isSearch">
            <!-- Карточка товара -->
            <div v-for='(product,i) in products' :key='i' class="col-6 col-lg-4 " style="padding-left: 5px; padding-right: 5px;">
              <product-gallery-card :product="product" />
            </div>
          </div>

          <!-- Nothing Found -->
          <span v-if="products.length < 1 && isFetched && !isWaterfalling" style="display: flex;justify-content: center;  width: 100%;  margin: 20px 0;">
            <b>Ничего не найдено</b>
          </span>            
          
          <!-- Loading -->
          <div v-if="(!isMobile || active) && (isWaterfalling || !isFetched)" style="display: flex;justify-content: center;  width: 100%;  margin: 20px 0;">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>

          <!-- Not found -->
          <div v-if="!isWaterfalling" style="display: flex;justify-content: center;  width: 100%;  margin: 20px 0;">              
            <a href="/" v-if="isMobile && $route.path == '/discounts'"><button class="btn-yellow btn-thick">Перейти в каталог магазина</button></a>
            <product-not-found v-else />   
          </div>   
                

        </div>


        <!-- <categories-slider /> -->

      </div>
    </div>
  </main>

  <!-- Invite popup -->
  <x-popup v-if="showInvitePopup" :title="'Вы приглашены в закупку!'" :active="showInvitePopup" @close="showInvitePopup=false" id="share-order-neighbor-modal">
    <div class="m-3">
      <!-- Вы приглашены в совместную закупку продуктов по оптовым ценам! Вы можете присоединиться к закупке как после того как соберете свой заказ, так и до этого, нажав кнопку "Присоединиться к закупке" в шапке профиля. -->
      Вы приглашены в совместную закупку! Вы можете либо сразу присоединиться к закупке, либо после того, как соберёте свой заказ, нажав кнопку «Присоединиться к закупке» в шапке профиля.
    </div>
  </x-popup>

</juge-main>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    halloween:halloween,isX:isX,
    busy:false,
    categoriesActive:false,
    showUp:false,
    showInvitePopup:false,
  }},
  computed:{
    ...mapGetters({
      products:'product/get',
      inputs:'product/getInputs',
      errors:'product/getErrors',
      cart:'cart/getCart',
      filters:'product/getFilters',
      categories:'category/getAll',      
      pages:'product/getPages',
      infinite:'product/getInfinite',
      isFetched:'product/isFetched',
      isWaterfalling:'product/isWaterfalling',
      active:'category/getActive',
      getCurrentFilters:'product/getFilters'
    }), 
    isMobile:function(){return window.screen.width <= 768;},
    currentCategory:function(){
      if (this.categories[0] != undefined) {
        let cat =  this.categories.find(x => x.id == this.filters.category);
        if (cat != undefined) return cat;
        return  {id:0,name:''};
      }       
        
      return {id:0,name:''};
    },
    parentCategory:function(){
      if (this.$route.params.parent_cat_id == undefined) return {'id':0,'name':''};
      if (this.categories[0] == undefined) return {'id':0,'name':''};
      return this.categories.find(x => x.id == this.$route.params.parent_cat_id);
    },
    isSearch:function(){
      if(this.getCurrentFilters == undefined) return false;
      if(this.getCurrentFilters.search == undefined) return false;
      if(this.getCurrentFilters.search == '') return false;

      return true;
    }
  },
  async mounted(){

    //Show invite popup
    if(this.$route.query != undefined && this.$route.query.invited){
      this.showInvitePopup = true;
      this.$router.push('/');
    }

    this.fetchFavorites();
    this.setWaterfall(1);
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

.home .title-h1 {
  margin-top: 20px !important; 
  margin-bottom: 20px !important; 
}

.breadcrumb-sad-item a{
  color:black !important; 
  text-decoration: underline !important; 
}

.halloween .product-list-wrapper{
  background-image: url(/halloween/tikva_ulibka.png);
  background-size: 100px;
  background-repeat: no-repeat;
  background-position: bottom right;
}

.moto{
  max-width:850px;
  font-size: 44px;
  line-height: 140%;
  margin-top:50px;
  margin-bottom:80px;
}

@media screen and (max-width: 768px){

  .moto{
    font-size: 20px;
    line-height: 130%;
    margin-top:30px;
    margin-bottom:40px;
  }

  .halloween .home{
    background-image: url('/halloween/mish.png');
    background-size: 100px;
    background-repeat: no-repeat;
    background-position: top right;
  }

  .halloween .home, .halloween .product-list-wrapper{
    background-size: 50px !important;
  }
}


</style>