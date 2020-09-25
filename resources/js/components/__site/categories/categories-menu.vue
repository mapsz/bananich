<template>
  <div  class="sitebar sitebar-cat">
    <div class="sitebar-title">Разделы</div>
    <ul  class="sitebar-wrap">
      <!-- All -->
      <li class="sitebar-category sitebar-category-all" :class="!active ? 'active' : ''">
        <a @click.prevent="setPopular()" class="sitebar-link " href="/">Популярное</a>
      </li>
      <!-- Categories -->
      <li 
        v-for='(category,i) in categories' :key='i'
        :class="active.id == category.id ? 'active' : ''"
        class="sitebar-category"
      >
        <!-- <a
          class="sitebar-link"
          @click.prevent="changeCategory(category)"
          :href="'/category/'+category.id"
        >
          <div class="sitebar-text">{{category.name}}</div> 
        </a> -->

        <!-- <a @click.prevent="" :href="'/category/'+category.id" class="sitebar-link" data-toggle="collapse" >aaa</a> -->

        <template> 
          <a 
            @click.prevent="" 
            class="sitebar-link"  
            data-toggle="collapse"  
            :href="'#multiCollapseExample'+category.id" 
            :aria-controls="'multiCollapseExample'+category.id" 
          >{{category.name}}</a>

          <div class="pl-3 collapse multi-collapse" :id="'multiCollapseExample'+category.id"  >
            <ul  class="sitebar-wrap">
              <li 
                v-for='(cat,i) in category.categories' :key='i'
                :class="active.id == cat.id ? 'active' : ''"
                class="sitebar-category"
                style="margin-bottom:10px"
              >
                <a                  
                  class="sitebar-link"
                  @click.prevent="changeCategory(cat)"
                  :href="'/category/'+cat.id"
                >
                  <div class="sitebar-text">{{cat.name}}</div> 
                </a> 
              </li>   
            </ul>        
          </div>
        </template> 
      </li>
    </ul>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
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
    products: function(){
      console.log(this.products);
    },
    $route: function(){
      this.setRoute();
    },
  },
  async mounted(){
    await this.fetch();
    this.setRoute();
  },
  methods:{
    ...mapActions({
      setActive:'category/setActive',
      fetch:'category/fetch',
      addFilter:'product/addFilter',
      fetchProducts:'product/fetchData',
    }),    
    async changeCategory(category){
      //Category in cat
      if(!(category.categories != undefined && category.categories[0])){
        //Set Products
        this.setActive(category);
        await this.addFilter({'popular':0})  
        this.addFilter({'category':category.id})  
        this.fetchProducts();
        this.$router.push('/category/'+category.id);
      }
    },
    async setPopular(){
      this.$router.push('/');
      this.setActive(false);
      await this.addFilter({'category':0})  
      await this.addFilter({'popular':1})  
      this.fetchProducts();    
    },
    async setRoute(){
      this.setActive(false);
      let id = this.$route.params.id;
      //Get base categories
      if(id == undefined){
        this.setPopular();
        return;
      }

      //Check picked category
      let category = this.categories.find(x => x.id == id);

      //Category not found
      if(category == undefined){
        this.$router.push('/');
        this.setPopular();
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
        return;
      }
    }
  }
}
</script>

<style>

</style>