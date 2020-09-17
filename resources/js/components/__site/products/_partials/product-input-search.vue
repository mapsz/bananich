<template>  
  <form @submit.prevent="doSearch()" class="search">
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
  methods:{
    ...mapActions({
      'addFilter':'product/addFilter',
      'productsFetch':'product/fetchData',
    }),
    async doSearch(){
      await this.addFilter({'category':false});
      await this.addFilter({'search':this.search});
      await this.productsFetch();

      this.search = '';
    }
  },
}
</script>

<style>

</style>