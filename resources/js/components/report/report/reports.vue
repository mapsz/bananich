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
    <list-table :model="'report'"></list-table>  

    <!-- <juge-list :data="'report'"></juge-list> -->
  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    filters:{
      suppliers:[],
    }
  }},
  computed:{
    ...mapGetters('report',{data:'get'}),
  },
  mounted(){
    this.fetch();
  },  
  methods:{
    ...mapActions('report',['fetch']),
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