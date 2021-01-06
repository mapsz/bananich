<template>
<div>
  <gruzka-navbar></gruzka-navbar>  
  <!-- <pages-navbar></pages-navbar>   -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-8">   
        <juge-form :inputs="inputs" :errors="errors" @submit="submit"></juge-form>
      </div>

      <div class="col-12 col-lg-4">   
        <!-- Menus -->
        <div>
          <h5>Меню</h5>
          <div>
            <span v-for='(menu,i) in menus' :key='i' style="display:block">
              <span 
                v-if="!menu.pages.find(x => x.id == id)"
                @click="attach(menu.id)" 
                style="cursor:pointer">
                🔗
              </span>
              <span
                v-else
                @click="detach(menu.id)" 
                style="cursor:pointer">       
                ❌  
              </span>
              <span
                :class="'text-' +  (!menu.pages.find(x => x.id == id) ? 'danger' : 'success')"
              >
                {{menu.name}} 
              </span>            
            </span>
          </div>
        </div>
        <!-- Site -->
        <div class="mt-4">
          <h5>Сайт</h5>
          <div>
            <span v-for='(site,i) in sites' :key='i' style="display:block">
              <span 
                v-if="!site.pages.find(x => x.id == id)"
                @click="attachSite(site.id)" 
                style="cursor:pointer">
                🔗
              </span>
              <span
                v-else
                @click="detachSite(site.id)" 
                style="cursor:pointer">       
                ❌  
              </span>
              <span
                :class="'text-' +  (!site.pages.find(x => x.id == id) ? 'danger' : 'success')"
              >
                {{site.name}} 
              </span>            
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    id:false,
    edit:false,
    content:'',
  }},
  computed:{
    ...mapGetters({
        page:'page/getOne',
        inputs:'page/getInputs',
        errors:'page/getErrors',
        menus:'menu/get',
        sites:'site/get',
      }),    
  },
  async mounted(){
    //Get menus
    this.fetchMenus();
    
    //Get page
    this.id = this.$route.params.id;
    await this.fetchPage(this.id);
    await this.fetchSites(this.id);
    this.fetchInputs();
  },
  methods:{
    ...mapActions({
      'fetchPage':'page/fetchOne',
      'fetchInputs':'page/fetchInputs',
      'fetchMenus':'menu/fetchData',
      'fetchSites':'site/fetchData',
    }),
    async submit(data){
      data.id = this.id;
      let r = await ax.fetch('/page',data,'post');  
      location.href = "/admin/pages";
    },
    async attach(id){
      let r = await ax.fetch('/page/menu/attach',{pageId:this.id,menuId:id},'post');  
      this.fetchMenus();
    },
    async detach(id){
      let r = await ax.fetch('/page/menu/detach',{pageId:this.id,menuId:id},'post');  
      this.fetchMenus();
    },
    async attachSite(id){
      let r = await ax.fetch('/page/site/attach',{pageId:this.id,siteId:id},'post');  
      this.fetchSites();
    },
    async detachSite(id){
      let r = await ax.fetch('/page/site/detach',{pageId:this.id,siteId:id},'post');  
      this.fetchSites();
    }
  },
}
</script>

<style>

</style>