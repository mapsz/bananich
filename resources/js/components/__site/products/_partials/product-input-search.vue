<template>  
  <form @submit.prevent="doSearch()">
    <input v-model="search" class="search-input" type="text" placeholder="Поиск">
    <button class="search-btn"><img src="/image/search.svg" alt="search"></button>
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
  },
  watch: {
    getCurrentFilters: {
      handler: function (val, oldVal) {
        if(this.getCurrentFilters.search != undefined && this.getCurrentFilters.search !== ""){
          this.search = this.getCurrentFilters.search;
        }
      },
      deep: true
    }
  },
  methods:{
    ...mapActions({
      'addFilter':'product/addFilter',
      'productsFetch':'product/fetchData',
    }),
    async doSearch(){
      await this.addFilter({'category':false});
      await this.addFilter({'search':this.search});
      await this.productsFetch();
    }
  },
}
</script>

<style>

</style>