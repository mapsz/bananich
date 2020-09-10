<template>
  <div>
    <gruzka-navbar></gruzka-navbar>  
    <product-navbar></product-navbar>

    <div class="container-fluid my-3">

    <!-- Title -->
    <h2 class="text-center my-3">{{category.name}} <a :href="'/category/'+id">{{id}} <span style="font-size:12pt">(просмотр)</span></a> </h2>
  
    <div class="row">

      <div class="col-6">   
        <juge-form :inputs="inputs" :errors="errors" @submit="submit"></juge-form>
      </div>

      <div class="col-6" v-if="id">
        <!-- Main Photo -->
        <category-photo class="mb-3 border p-2" />
        <!-- Products -->
        <category-products class="mb-3 border p-2" />
        <!-- Categories -->
        <category-categories class="mb-3 border p-2" />
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
  errors:[],
}},
computed:{
  ...mapGetters({
    category: 'category/getOne',
    inputs:   'category/getInputs'
  }),    
},
async mounted(){  
    //Get
    if(this.$route.params.id > 0){
      this.id = this.$route.params.id;
    }

    //Fetch category
    if(this.id){
      await this.fetch(this.id);
    }

    //Fetch inputs
    this.fetchInputs();
}, 
methods:{
  ...mapActions({
    'fetch'         :'category/fetchOne',    
    'fetchInputs'   :'category/fetchInputs',
  }),
  async submit(inputs){

    inputs.id = this.category.id;

    let r = await ax.fetch('/category', inputs, 'post');

    location.reload();
  }
},
}
</script>

<style>

</style>