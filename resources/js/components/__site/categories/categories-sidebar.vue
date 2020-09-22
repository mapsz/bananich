<template>
  <div class="col-lg-4" >            
    <div class="sitebar sitebar-cat">
      <div class="sitebar-title">Разделы</div>
      <ul class="sitebar-wrap">
        <!-- All -->
        <li class="sitebar-category sitebar-category-all" >
          <a class="sitebar-link " href="/">Все</a>
        </li>
        <!-- Categories -->
        <li 
          v-for='(category,i) in categories' :key='i'
          :class="active == category.id? 'active' : ''"
          class="sitebar-category"
        >
          <a
            class="sitebar-link"
            @click.prevent="changeCategory(category)"
            :href="'/category/'+category.id"
          >
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
model: {event: 'blur'},
data(){return{
  active:false,
  activeCategoty:'',
}},
computed:{...mapGetters({categories:'category/get',}),}, 
watch: {
  active: async function(val, oldVal){
    if(val == oldVal) return;
    await this.addFilter({category:this.active});
    await this.productFetch();
    this.$emit('change',this.activeCategoty);
    this.$emit('blur',this.active);
  },
  $route: async function(){
    this.active = this.$route.params.id != undefined ? this.$route.params.id : false;
    this.activeCategoty = this.categories.find(x => x.id == this.$route.params.id);
  },
},
async mounted(){
  this.setWaterfall(1);
  await this.fetch();
  if(this.$route.params.id != undefined){
    this.active = this.$route.params.id;
    this.activeCategoty = this.categories.find(x => x.id == this.$route.params.id);    
  }else{
    this.productFetch();
  }
},
methods:{
  ...mapActions({
    'addFilter':'product/addFilter',
    'productFetch':'product/fetchData',
    'setWaterfall':'product/setWaterfall',
    'fetch':'category/fetch',
  }),
  changeCategory(category){
    this.active = category.id;
    this.activeCategoty = category;
    this.$router.push('/category/'+category.id);
  }
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