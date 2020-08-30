<template>
  <div class="col-lg-4" :class="active === false ? '' : 'mobile-hide'">            
    <div class="sitebar sitebar-cat">
      <div class="sitebar-title">Разделы</div>
      <ul class="sitebar-wrap">
        <!-- All -->
        <li class="sitebar-category sitebar-category-all" :class="!active ? 'active' : ''">
          <a class="sitebar-link " v-on:click.prevent="active = false" href="">Все</a>
        </li>
        <!-- Categories -->
        <li 
          v-for='(category,i) in categories' :key='i'
          :class="active == category.id? 'active' : ''"
          class="sitebar-category"
        >
          <a class="sitebar-link" v-on:click.prevent="active = category.id; activeCategoty=category" href="">
            <div class="sitebar-text">{{category.name}}</div> 
            <div class="sitebar-bg" :style='"background-image: url("+category.photo+"); background-color: #ebeff2;"'></div>
          </a>
        </li>
      </ul>
    </div>            
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  active:false,
  activeCategoty:'',
}},
computed:{...mapGetters({categories:'category/get',}),}, 
watch: {
  active: async function(){
    await this.addFilter({category:this.active})
    this.productFetch();
    this.$emit('change',this.activeCategoty);
  },
},
mounted(){
  this.fetch();
},
methods:{
  ...mapActions({
    'addFilter':'product/addFilter',
    'productFetch':'product/fetchData',
    'fetch':'category/fetch',
  }),
},
}
</script>

<style scoped>
  @media (max-width: 768px){
    .mobile-hide {
      display:none;
    }
  }
</style>