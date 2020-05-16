<template>
<div>

  <b-table :head-variant="'dark'" striped hover small borderless :items="jData"></b-table>

</div>
</template>

<script>
export default {
props: ['data','keys'],
data(){return{
  jData: [],
  jKeys: false,
  dataModel:false,
}},
watch: {
  data: {
    handler: function (val, oldVal) {
      this.setDataType(this.data);
    },
    deep: true
  },
  dataModel: function(){
    if(this.dataModel.s != undefined && this.dataModel.s){
      this.getDataFromModel(this.dataModel.s);
    }
  },
},
computed:{
  gg:function(){
    if(this.$store.getters[this.dataModel.s+'/get'] != undefined) return this.$store.getters[this.dataModel.s+'/get']
  }
},
async mounted(){
  await this.setDataType(this.data);
},
methods:{
  setDataType(data){
    if(typeof(data) == 'string'){
      this.setDataModel(JSON.parse(JSON.stringify(data)));
    }      
    if(typeof(data) == 'object'){
      this.jData = JSON.parse(JSON.stringify(data));
    }
  },
  setDataModel(model){
    this.dataModel = {'s':false,'m':false};
    this.dataModel.s = model;
    this.dataModel.m = this.setMulti(model);
  },
  setMulti(model){
    return model[0] + model.substr(1) + 's';
  },
  getDataFromModel(model){
    console.log(model);
    console.log(this.$store.getters[model+'/get']);
    
    if(this.$store.getters[model+'/get'] != undefined) {
      this.jData = this.$store.getters[model+'/get'];
    }      
  }
  
},
}
</script>

<style>

</style>