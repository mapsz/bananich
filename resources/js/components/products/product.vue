<template>
<div>
  <gruzka-navbar></gruzka-navbar>


  <div class="container-fluid mb-3">

    <h2 v-if="id" class="text-center my-3">{{product.name}} <a :href="'/product/'+id">{{id}} <span style="font-size:12pt">(просмотр)</span></a></h2>
    
    <div class="row">
      <div class="col-8">   
        <juge-form :inputs="inputs" :errors="errors" @submit="submit"></juge-form>
      </div>
      <div class="col-4" v-if="id">
        <!-- Published -->
        <product-published class="mb-3 border p-2" />
        <!-- Main Photo -->
        <product-main-photo class="mb-3 border p-2" />
        <!-- Bonuses -->
        <product-bonus class="mb-3 border p-2" />
        <!-- Categories -->
        <product-categories class="mb-3 border p-2" />
        <!-- Discount -->
        <!-- <product-discount-edit class="mb-3 border p-2" /> -->
        <!-- Delivery Days -->
        <product-delivery-days class="mb-3 border p-2" />
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
      await this.$store.dispatch('product/addFilter',{get_all:1});
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
        this.post(inputs);
        location.reload();
      }else{
        let $id = await this.put(inputs);
        location.href = '/admin/product/'+$id;
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