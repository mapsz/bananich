<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>
  
  <div class="container-fluid">

    <h1>Списание</h1>

    <!-- Actions -->
    <div class="mb-3">
      <!-- Add -->
      <div class="purchases-add">
        <button v-if="!add" @click="add=true" class="btn btn-success">Списать</button>
        <div v-if="add">
          <add-writeoff @close="add=false" @writeoff-success="writeoffSuccess"></add-writeoff>
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
    async writeoffSuccess(){
      this.get();
    }
  },
}
</script>

<style>

</style>