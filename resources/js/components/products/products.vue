<template>
<div>  
  <gruzka-navbar></gruzka-navbar>
  <div class="container-fluid">
    <!-- Title -->
    <h1>Продукты</h1>
    <!-- Add Field -->
    <router-link class="navbar-brand" to="/product/add">
      <button class="btn-success btn">Добавить</button>
    </router-link>

    <!-- List -->
    <list-table :data="products" :model="'products'"></list-table>  
    
  </div>
</div>
</template>

<script>
export default {
data(){return{
  products:[],
}},
mounted(){
  this.getProducts();
},
methods:{
  async getProducts(){
    //Get
    let r = await this.jugeAx('/json/products/');
    this.products = r;   
  }
},
}
</script>

<style>

</style>