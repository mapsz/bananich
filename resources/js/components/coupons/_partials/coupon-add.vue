<template>
<div class="add">
  <h3 class="d-inline-block">Добавить купон</h3>


  <!-- Form -->
  <div >
    <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    //
  }},
computed:{
  ...mapGetters({
    inputs:   'coupon/getInputs',
    errors:   'category/getErrors'
  }),    
},
  mounted(){
    this.fetchInputs();
  },
  methods:{ 
    ...mapActions({
      'fetchInputs':'coupon/fetchInputs',
    }),
    async put(data){
      let r = await ax.fetch('/coupon',data,'put');  
      location.reload();      
    },    
  },
}
</script>

<style scoped>
  .add {
      background-color: #e4f9e4;
      padding: 20px;
      border: 1px solid green;
      border-radius: 7px;
      margin: 10px 0px;
  }
</style>