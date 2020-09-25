<template>
  <div v-if="!active">
  <ul  class="sitebar-wrap">
    <!-- Categories -->
    <template v-for='(category,i) in categories'>
      <li 
        :key="i"   
        v-if="category.main_menu == 1"
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
    //
  }},
  computed:{
    isMobile:function(){return window.screen.width <= 768;},
    ...mapGetters({
      categories:'category/get',
      active:'category/getActive',
      products:'product/get',
      getCurrentFilters:'product/getFilters'
    }),
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
      //Scroll
      $('html,body').stop().animate({ scrollTop: ($('.content-page').offset().top - 100)}, 300);
      //Route
      this.$router.push('/category/'+category.id);
    },
    async setRoute(){
      if(!this.isMobile) return;
      this.setActive(false);
      let id = this.$route.params.id;
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