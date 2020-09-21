<template>
<div>
  <gruzka-navbar></gruzka-navbar>  
  <pages-navbar></pages-navbar>  

  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8">   
        <juge-form :inputs="inputs" :errors="errors" @submit="submit"></juge-form>
      </div>

      <div class="col-12 col-lg-4">   
        <!-- Menus -->
        <h5>Меню</h5>
        <div>
          <span v-for='(menu,i) in menus' :key='i' style="display:block">
            <span 
              v-if="!menu.pages.find(x => x.id = id)"
              @click="attach(menu.id)" 
              style="cursor:pointer">
              🔗
            </span>   
            {{menu.name}} 
          </span>
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
      }),    
  },
  async mounted(){    
    //Get
    this.id = this.$route.params.id;

    this.fetchPage(this.id);
    this.fetchInputs();
    this.fetchMenus();
  },
  methods:{
    ...mapActions({
      'fetchPage':'page/fetchOne',
      'fetchInputs':'page/fetchInputs',
      'fetchMenus':'menu/fetchData',
    }),
    async submit(data){
      data.id = this.id;
      let r = await ax.fetch('/page',data,'post');  
      location.href = "/admin/pages";
    },
    async attach(id){
      let r = await ax.fetch('/page/menu/attach',{pageId:this.id,menuId:id},'post');  
      location.reload();
    }
  },
}
</script>

<style>

</style>