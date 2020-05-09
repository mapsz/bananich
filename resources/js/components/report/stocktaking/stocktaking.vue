<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <!-- List -->
  <list-table :data="data" :model="'stocktaking'"></list-table>

</div>  
</template>

<script>
export default {
  data(){return{
    data:[],
  }},
  mounted(){
    // this.add=true;
    this.get();
  },
  methods:{
    async get(){
      let r = await this.jugeAx('/json/stocktaking/products');
      if(!r) return;
      this.data = r;      
    },
    async writeoffSuccess(){
      this.get();
    }
  },
}
</script>

<style>

</style>