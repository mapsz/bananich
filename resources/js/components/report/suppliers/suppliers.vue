<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <div class="container-fluid">

    <h1>Поставщики</h1>

    <!-- Actions -->
    <div class="mb-3">
      <!-- Add -->
      <div class="suppliers-add">
        <button v-if="!add" @click="add=true" class="btn btn-success">Добавить</button>
        <div v-if="add">
          <add-suppliers @close="add=false" @add-success="addSuccess"></add-suppliers>
        </div>
      </div>
    </div>  

    <!-- List -->
    <div class="">
      <list-table :data="list" :model="'suppliers'"></list-table>
    </div>
  
  </div>

</div>
</template>

<script>
export default {
data(){return{
  add:false,
  list:[],
}},
mounted(){
  // this.add=true;
  this.get();
},
methods:{
  async get(){
    let r = await this.jugeAx('/json/suppliers');
    if(!r) return;
    this.list = r;
  },
  addSuccess(add){
    console.log(add);
    this.add=false;
    this.list = [add].concat(this.list);
     
  }
},
}
</script>

<style>

</style>