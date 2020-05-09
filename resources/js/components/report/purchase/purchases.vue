<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>
  
  <div class="container-fluid">

    <h1>Закупка</h1>

    <!-- Prices -->
    <div>
    <a href="/report/purchase/prices"><button class="btn btn-warning">Цены</button></a>
    </div>
    

    <!-- Actions -->
    <div class="my-3">
      <!-- Add -->
      <div class="purchases-add">
        <button v-if="!add" @click="add=true" class="btn btn-success">Добавить</button>
        <div v-if="add">
          <add-purchase @close="add=false" @add-success="addSuccess"></add-purchase>
        </div>
      </div>
    </div>  
    
    <!-- List -->
    <list-table :data="goods" :model="'purchases'"></list-table>

  </div>

</div>
</template>

<script>
export default {
  data(){return{
    add:false,
    goods:[],
  }},
  mounted(){
    // this.add=true;
    this.get();
  },
  methods:{
    async get(){
      let r = await this.jugeAx('/json/goods');
      if(!r) return;
      this.goods = r;      
    },
    async addSuccess(){
      this.get();
    }
  },
}
</script>

<style>

</style>