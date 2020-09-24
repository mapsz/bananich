<template>
<div class="container-fluid">


  <!-- Form -->
  <div >
    <h5>Добавить</h5>
    <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
  </div>



</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  add:false,
  errors:false
}},
  computed:{
    ...mapGetters({inputs:'bonus/getInputs'}),    
  },
  mounted(){
    this.fetchInputs();
  },
  methods:{ 
    ...mapActions({
      'fetchInputs':'bonus/fetchInputs',
    }),
    async put(data){
      this.errors = false;

      let r = await ax.fetch('/bonus/add',data,'put');

      //Catch errors
      if(!r){      
        if(ax.lastResponse.status == 422){
          this.errors = ax.lastResponse.data.errors;
          return;
        }
      }


      if(r) location.reload();
    }
  }
}
</script>

<style scoped>
  .add-bonus-container {
      background-color: #e4f9e4;
      padding: 20px;
      border: 1px solid green;
      border-radius: 7px;
      margin: 10px 0px;
  }
</style>