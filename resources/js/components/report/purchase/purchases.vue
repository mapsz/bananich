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
    <juge-list :data="'purchase'"></juge-list>

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
    //
  },
  methods:{
    async addSuccess(){
      this.get();
    }
  },
}
</script>

<style>

</style>