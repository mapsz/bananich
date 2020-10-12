<template>  
  <form class="d-flex" @submit.prevent="doSearch()">
    <input v-model="search" class="search-input" type="text" placeholder="Поиск">
    <button class="search-btn-fix" style="margin-left: -30px;"><img src="/image/search.svg" alt="search"></button>
    <span v-if="searchFilter" @click="search = '';doSearch()" class="ml-3 align-self-center" style="cursor:pointer">❌</span>
  </form>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    search:'',
  }},
  computed:{  
    ...mapGetters({'getCurrentFilters':'product/getFilters',}),
    searchFilter:function(){
      return (this.getCurrentFilters.search != undefined && this.getCurrentFilters.search !== "") ?  true : false;
    }
  },
  watch: {
    getCurrentFilters: {
      handler: function (val, oldVal) {
        if(this.getCurrentFilters.search != undefined && this.getCurrentFilters.search !== ""){
          this.search = this.getCurrentFilters.search;
        }
      },
      deep: true
    },
  },
  methods:{
    ...mapActions({
      'addFilter':'product/addFilter',
      'clearFilters':'product/clearFilters',
      'productsFetch':'product/fetchData',
    }),
    async doSearch(){
      if(this.$route.path != '/') this.$router.push('/');      
      await this.clearFilters();
      await this.addFilter({'search':this.search});
      await this.productsFetch();
    }
  },
}
</script>

<style scoped>
  /* .search-btn-fix{

  } */
</style>