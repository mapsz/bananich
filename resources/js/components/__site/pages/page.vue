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
      
      let curPage = false;
      $.each(this.pages , ( k, page ) => {
        console.log('/'+page.link);
        console.log(this.$route.path);
        console.log('---');
        if('/'+page.link == this.$route.path){
          curPage = page;
          return;
        }
      });

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