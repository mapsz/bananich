<template>
  <div v-if="!active && !isSearch">
  <ul  class="sitebar-wrap">
    
    <!-- Discounts -->
    <li v-if="!parent" class="sitebar-category">
      <a
        class="sitebar-link"
        @click.prevent="setDiscounts()"
        :href="'/discounts/'"
      >
        <div class="sitebar-text">Акции</div> 
        <div class="sitebar-bg" :style='"background-image: url(/image/r-1.png); background-color: #ebeff2;"'></div>
      </a>
    </li>
    <!-- Categories -->
    <template v-for='(category,i) in categories'>
      
      <li 
        :key="i"   
        v-if="category.main_menu == 1 || parent"
        :class="active.id == category.id ? 'active' : ''"
        class="sitebar-category"
      >
        <a
          class="sitebar-link"
          @click.prevent="changeCategory(category)"
          :href="'/category/'+category.id"
        >
          <div class="sitebar-text">{{category.name}}</div> 
          <div class="sitebar-bg" :style='"background-image: url("+category.mainImage+"); background-color: #ebeff2;"'></div>
        </a>

      </li>
    </template>
  </ul>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    parent:false,
  }},
  computed:{
    isMobile:function(){return window.screen.width <= 768;},
    ...mapGetters({
      categories:'category/get',
      active:'category/getActive',
      products:'product/get',
      getCurrentFilters:'product/getFilters'
    }),
    currentCategory:function(){
      if (this.$route.params.cat_id == undefined) return {'id':0,'name':''};
      if (this.categories[0] == undefined) return {'id':0,'name':''};

      return this.categories.find(x => x.id == this.$route.params.cat_id);
    },
    isSearch:function(){
      if(this.getCurrentFilters == undefined) return false;
      if(this.getCurrentFilters.search == undefined) return false;
      if(this.getCurrentFilters.search == '') return false;

      return true;
    }
  },
  watch: {
    $route: function(){
      if(!this.isMobile) return;
      this.setRoute();
    },
  },
  async mounted(){
    if(!this.isMobile) return;

    this.setActive(false);
    await this.fetch();
    this.setRoute();
  },
  methods:{
    ...mapActions({      
      fetchProducts:'product/fetchData',
      addFilter:'product/addFilter',
      setActive:'category/setActive',
      fetch:'category/fetch',
      setCategories:'category/setCategories',
    }), 
    async changeCategory(category){
      if(!this.isMobile) return;

      //Remove discount
      await this.addFilter({'only_discounts':0});
      //Scroll
      $('html,body').stop().animate({ scrollTop: ($('.content-page').offset().top-200)}, 300);
      //Route
      let route = this.$route.path == '/' ? '' : this.$route.path;
      this.$router.push(route+'/category/'+category.id);
    },
    setDiscounts(){
      if(!this.isMobile) return;
      //Scroll
      $('html,body').stop().animate({ scrollTop: ($('.content-page').offset().top-200)}, 300);
      //Route
      this.$router.push('/discounts');
    },
    async setRoute(){
      if(!this.isMobile) return;
      this.parent = false;
      this.setActive(false);
      

      if(this.$route.path == "/discounts"){
        //Set Products
        await this.setActive(1);
        await this.addFilter({'category':0});
        await this.addFilter({'only_discounts':1});
        this.fetchProducts(); 
        return;       
      }

      let id = this.$route.params.cat_id;
      //Get base categories
      if(id == undefined){
        this.fetch();
        return;
      }

      //Check picked category
      let category = this.categories.find(x => x.id == id);

      //Category not found
      if(category == undefined){
        this.$router.push('/');
        return;
      }

      //Category in cat
      if(category.categories != undefined && category.categories[0]){
        this.parent = category;
        this.setCategories(category.categories);
        return;
      }else{
        //Set Products
        this.setActive(category);
        this.addFilter({'category':category.id})  
        this.fetchProducts();
      }
    }
  }
}
</script>

<style>

</style>