<template>
  <div  class="sitebar sitebar-cat" :class="halloween?'halloween':''">
    <div class="sitebar-title">Разделы</div>
    <ul  class="sitebar-wrap">
      <!-- Discounts -->
      <li v-if="!isX" class="sitebar-category sitebar-category-all" :class="!active ? 'active' : ''">
        <a @click.prevent="setDiscounts()" class="sitebar-link " href="/">Акции</a>
      </li>
      <!-- Popular -->
      <li v-if="isX" class="sitebar-category sitebar-category-all" :class="!active ? 'active' : ''">
        <a @click.prevent="setPopular()" class="sitebar-link " href="/">Популярное</a>
      </li>
      <!-- Categories -->
      <template v-for='(category,i) in categories'>
        <li        
          :key="i"   
          v-if="category.main_menu == 1"
          :class="active.id == category.id ? 'active' : ''"
          class="sitebar-category"
        >
          <template v-if="category.categories != undefined && category.categories[0]"> 
            <a 
              @click.prevent="" 
              class="sitebar-link dropdown-sad-btn active"  
              data-toggle="collapse"  
              :href="'#CollapseCategory-'+category.id" 
              :aria-controls="'CollapseCategory-'+category.id" 
            >{{category.name}}</a>

            <div class="pl-3 collapse multi-collapse" :id="'CollapseCategory-'+category.id"  >
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

          <a
            v-else
            class="sitebar-link"
            @click.prevent="changeCategory(category)"
            :href="'/category/'+category.id"
          >
            <div class="sitebar-text">{{category.name}}</div> 
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
    isX:isX,
    halloween:halloween,
  }},
  computed:{
    isMobile:function(){return window.screen.width <= 768;},
    ...mapGetters({
      categories:'category/get',
      active:'category/getActive',
      products:'product/get',
      getCurrentFilters:'product/getFilters'
    }),
    currentCategories:function(){
      //
    }
  },
  watch: {
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
      if(category.categories == undefined || category.categories[0] == undefined){
        
        //Set Products
        this.setActive(category);
        await this.addFilter({'only_discounts':0})  
        await this.addFilter({'popular':0})  
        this.addFilter({'category':category.id})  
        this.fetchProducts();
        
        //Route
        let route = '/category/'+category.id;
        this.$router.push(route);
      }
    },
    async setPopular(){
      if(this.$route.path != '/') this.$router.push('/');
      this.setActive(false);
      await this.addFilter({'category':0});  
      await this.addFilter({'popular':1}) ; 
      this.fetchProducts();    
    },
    async setDiscounts(){
      if(this.$route.path != '/') this.$router.push('/');
      this.setActive(false);
      await this.addFilter({'category':0});
      await this.addFilter({'only_discounts':1});
      this.fetchProducts(); 
    },
    async setRoute(){
      this.setActive(false);
      let id = this.$route.params.cat_id;
      //Get base categories
      if(id == undefined){
        if(this.isX){
          this.setPopular();
        }else{
          this.setDiscounts();
        }
        return;
      }

      //Check picked category
      let category = this.categories.find(x => x.id == id);

      //Category not found
      if(category == undefined){
        this.$router.push('/');
        if(this.isX){
          this.setPopular();
        }else{
          this.setDiscounts();
        }
        
        
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

<style scoped>

.halloween .sitebar-cat{
  background-image: url(/halloween/pautina_2.png);
  background-size: 150px;
  background-repeat: no-repeat;
  background-position: top right;
}

.page-x .sitebar{
  background: #e7dfdc!important;
}

@media screen and (max-width: 768px){

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