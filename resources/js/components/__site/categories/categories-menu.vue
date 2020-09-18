<template>
<div class="sitebar sitebar-cat">
  <div class="sitebar-title">Разделы</div>
  <ul v-if="!active || !isMobile" class="sitebar-wrap">
    <!-- All -->
    <li class="sitebar-category sitebar-category-all" :class="!active ? 'active' : ''">
      <a @click.prevent="setActive(0)" class="sitebar-link " href="/">Все</a>
    </li>
    <!-- Categories -->
    <li 
      v-for='(category,i) in categories' :key='i'
      :class="active.id == category.id ? 'active' : ''"
      class="sitebar-category"
    >
      <a
        class="sitebar-link"
        @click.prevent="setActive(category)"
        :href="'/category/'+category.id"
      >
        <div class="sitebar-text">{{category.name}}</div> 
        <div class="sitebar-bg" :style='"background-image: url("+category.photo+"); background-color: #ebeff2;"'></div>
      </a>

    </li>
  </ul>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    //
  }},
  watch: {
    active: function(){
      //Set route
      if('route' == 'route'){
        if (this.active.id == undefined) {
          if(this.$route.fullPath != '/') this.$router.push('/');          
        }else{
          if(this.$route.params.id == undefined ||this.$route.params.id != this.active.id)
            this.$router.push('/category/'+this.active.id)
        }     
      } 
    
      //Set filter
      let active = JSON.parse(JSON.stringify(this.active));
      if(active == false) 
        this.addFilter({'categories':[0]});
      else 
        this.addFilter({'categories':[active.id]});
      
      //Skip if mobile return to category list
      if(!(active == false && this.isMobile)) 
        this.fetchProducts();
    },
    $route: async function(){
      this.setActive(this.$route.params.id != undefined ? this.categories.find(x => x.id == this.$route.params.id) : false);
      // this.active = this.$route.params.id != undefined ? this.$route.params.id : false;
      // this.activeCategoty = this.categories.find(x => x.id == this.$route.params.id);
    },
  },
  computed:{
    ...mapGetters({
      categories:'category/get',
      active:'category/getActive',
    }),
    isMobile:function(){return window.screen.width <= 768;},
  },
  async mounted(){
    await this.fetch();
    //Set active from link
    this.setActive(this.$route.params.id != undefined ? this.categories.find(x => x.id == this.$route.params.id) : false);
  },
  methods:{
    ...mapActions({
      'setActive':'category/setActive',
      'fetch':'category/fetch',
      'addFilter':'product/addFilter',
      'fetchProducts':'product/fetchData',
    }),  
  },
}
</script>

<style>

</style>