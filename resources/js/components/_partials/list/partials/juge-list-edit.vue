<template>
<div v-if="model && isInputsFetched && inputsWithData">    
  <div class="mb-3" v-if="row.id != undefined"> <b>ID {{row.id}}</b> </div> 
  <juge-form :inputs="inputsWithData" :errors="errors" @submit="post"></juge-form>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['model','row'],
computed:{
  errors(){
    if(this.model == undefined || !this.model) return [];
    return this.$store.getters[this.model+'/getErrors'];
  },
  inputs(){
    if(this.model == undefined || !this.model) return false;
    return this.$store.getters[this.model+'/getInputs'];
  },
  isInputsFetched(){
    if(this.model == undefined || !this.model) return -1;
    return this.$store.getters[this.model+'/isInputsFetched'];
  },
  inputsWithData(){
    if(!this.inputs) return false;
    let out = [];
    this.inputs.forEach(input => {
      let row = JSON.parse(JSON.stringify(input));
      row.value = this.row[input.name];
      out.push(row);
    });
    return out;
  },  
},
watch:{
  isInputsFetched: function (val, oldVal) {
    this.fetchInputs();
  },
},
async mounted() {
  this.fetchInputs();
},
methods:{
  fetchInputs(){
    //Alredy fetched
    if(this.isInputsFetched === -1 || this.isInputsFetched === true) return false;
    //Bad model
    if(this.model == undefined || !this.model) return false;
    //Fetch
    this.$store.dispatch(this.model+'/fetchInputs');
  },
  async post(data){
    //Get id
    data.id = (this.row.id != undefined) ? this.row.id : false;
    //Vuex
    let r = await this.$store.dispatch(this.model+'/doEdit',data);
    //Toast
    Vue.toasted.show("edit success 🐸",{type:'success',position:'bottom-right'});
    //Emit
    if(r) this.$emit('editSuccess');
  }
},

}
</script>

<style>

</style>