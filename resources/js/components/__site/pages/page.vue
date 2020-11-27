<template>
  <div>
    <site-header/>
      <div class="container my-5">
        <span v-if="currentPage.text" class="" v-html="currentPage.text"></span>
      </div>
    <site-footer/>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      pages:'page/get',
    }),    
    currentPage(){
      if(this.pages == undefined) return false;
      if(this.pages.length < 1) return false;
      
      let curPage = false;
      $.each(this.pages , ( k, page ) => {
        if('/'+page.link == this.$route.path){
          curPage = page;
          return;
        }
      });

      if(!curPage) location.href = "/404";

      return curPage;
    }
  },
  async mounted(){   
    this.fetch();
  },
  methods:{
    ...mapActions({
      'fetch':'page/fetchData',
    }),
  }

}
</script>

<style>

</style>