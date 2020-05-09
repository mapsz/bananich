<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <div class="container-fluid">

    <h1>Цены закупок</h1>

    <!-- List -->
    <list-table :data="data" :model="'purchasePrices'" @success="get();"></list-table>

  </div>

  


</div>
</template>

<script>
export default {
data(){return{
  data:[],
}},
mounted(){
  this.get();
},
methods:{
  async get(){
    let r = await this.jugeAx('/json/purchase/prices');
    if(!r) return;
    this.data = r;      
  },
},
}
</script>

<style>

</style>