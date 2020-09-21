<template>
<div class="add">
  <h3 class="d-inline-block">Добавить меню</h3>


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
    ...mapGetters({inputs:'menu/getInputs',errors:'menu/getErrors'}),    
  },
  mounted(){
    this.fetchInputs();
  },
  methods:{ 
    ...mapActions({
      'fetchInputs':'menu/fetchInputs',
    }),
    async put(data){
      let r = await ax.fetch('/menu',data,'put');  
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