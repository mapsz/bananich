<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <div class="container-fluid">

    <!-- Filters -->
    <div class="my-2">
      <suppliers-filter @changed="suppliersChanged"></suppliers-filter>
    </div>

  
    <!-- List -->
    <list-table :data="data" :model="'report'"></list-table>  
  </div>

</div>
</template>

<script>
export default {
  data(){return{
    data:[],
    filters:{
      suppliers:[],
    }
  }},
  mounted(){
    this.get();
  },  
  methods:{
    async get(){
      let r = await this.jugeAx('/json/report',{
        suppliers:this.filters.suppliers,
      });
      if(r === 0) {
        this.data = [];
        return;
      }
      if(!r) return;
      this.data = r;      
    },
    suppliersChanged(suppliers){
      this.filters.suppliers = suppliers;
      this.get();
    }
    
  },
}
</script>

<style>

</style>