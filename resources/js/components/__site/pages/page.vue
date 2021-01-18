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
  data(){return{
    isX:isX,
  }},
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

      //404
      if(!curPage){
        location.href = "/404";
        return;
      } 
      
      {//Bad site
        let badSite = false;
        //No site
        if(curPage.site == undefined || curPage.site[0] == undefined) badSite = true;
        //No bananich
        if(!isX && curPage.site.findIndex(x => x.name == 'Bananich') < 0) badSite = true;
        //No neo
        if(isX && curPage.site.findIndex(x => x.name == 'Neo') < 0) badSite = true;
        //Redirect
        if(badSite){
          location.href = "/404";
          return false;
        } 
      }

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