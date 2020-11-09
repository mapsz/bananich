<template>
<div>

  <button v-if="!addShow" @click="addShow=true" class="btn btn-success">Добавить</button>

  <div v-if="addShow">
    <div class="add">
      <div>
        <h3 class="d-inline-block">Добавить купон</h3>
        <button class="btn btn-danger"  @click="addShow=false" style="float: right;">X</button>
      </div>
      <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
    </div>
  </div>
  
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    errors:[],
    addShow:false,
  }},
computed:{
  ...mapGetters({
    inputs:   'coupon/getInputs',
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
      this.errors = [];
      let r = await ax.fetch('/coupon',data,'put');
      //Catch errors
      if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

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