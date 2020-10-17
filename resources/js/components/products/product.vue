<template>
<div>
  <gruzka-navbar></gruzka-navbar>


  <div class="container-fluid mb-3">

    <h2 v-if="id" class="text-center my-3">{{product.name}} <a :href="'/product/'+id">{{id}} <span style="font-size:12pt">(просмотр)</span></a></h2>
    
    <div class="row">
      <div class="col-12 col-lg-8">   
        <juge-form :inputs="inputs" :errors="errors" @submit="submit"></juge-form>
      </div>
      <div class="col-12 col-lg-4" v-if="id">
        <!-- Discount -->
        <product-prices-edit class="mb-3 border p-2" />
        <!-- Published -->
        <product-published class="mb-3 border p-2" />
        <!-- In stock -->
        <product-in-stock class="mb-3 border p-2" />
        <!-- Main Photo -->
        <product-main-photo class="mb-3 border p-2" />
        <!-- Bonuses -->
        <product-bonus class="mb-3 border p-2" />
        <!-- Popular -->
        <product-popular class="mb-3 border p-2" />
        <!-- Termobox -->
        <product-termobox class="mb-3 border p-2" />
        <!-- Categories -->
        <product-categories class="mb-3 border p-2" />
        <!-- Delivery Limits -->
        <product-delivery-limits class="mb-3 border p-2" />
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
    ...mapGetters({product:'product/getOne',inputs:'product/getInputs',errors:'product/getErrors'}),    
  },
  async mounted(){   
    
    //Get
    if(this.$route.params.id > 0){
      this.id = this.$route.params.id;
    }

    //Fetch product
    if(this.id){
      await this.$store.dispatch('product/addFilter',{'with_summary':1});
      await this.fetchProduct(this.id);
    }
    
    //Fetch inputs
    this.fetchInputs();
    
  },
  methods:{
    ...mapActions({
      'fetchProduct':'product/fetchOne',
      'fetchInputs':'product/fetchInputs',
      'put':'product/put',
      'post':'product/post'
    }),
    async submit(inputs){
      if(this.id > 0){
        inputs.id = this.id;
        let r = await this.post(inputs);
        if(r){
          location.reload();
        } 
      }else{
        let $id = await this.put(inputs);
        if($id) location.href = '/admin/product/'+$id;        
      }
    }
  },
}
</script>

<style>
img {
  display: block;

  /* This rule is very important, please don't ignore this */
  max-width: 100%;
}
</style>