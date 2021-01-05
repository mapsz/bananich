<template>
<div>  
  <gruzka-navbar></gruzka-navbar>  
  <product-navbar></product-navbar>
  
  <div class="container-fluid">
    <!-- Title -->
    <h1>Продукты</h1>

    <div class="d-flex" style="justify-content: space-between;">
    <!-- Add Field -->
      <router-link class="navbar-brand" to="/admin/product/add">
        <button class="btn-success btn">Добавить</button>
      </router-link>

      <div>
        <button @click="noWeight()" class="btn-secondary btn">Без полного веса</button>
        <button @click="noType()" class="btn-secondary btn">Без типа единицы</button>
        <button @click="noPrice()" class="btn-secondary btn">Без цены</button>
        <button @click="noImage()" class="btn-secondary btn">Без главного фото</button>
        <button @click="noDescription()" class="btn-secondary btn">Без описание</button>
      </div>
    </div>  

    <!-- List -->
    <div>
      <div class="d-flex" style="justify-content: flex-end;">
        <product-category-filter :model="'product'"/>
      </div>      
      <juge-list :data="'product'" :pages="true"></juge-list>
    </div>
    
    
  </div>
</div>
</template>

<script>
export default {
  mounted(){
    this.$store.dispatch('product/addFilter',{get_all:1});
  },
  methods:{
    noType(){
      this.$store.dispatch('product/clearFilters');      
      this.$store.dispatch('product/addFilter',{no_type:1});      
    },
    noWeight(){
      this.$store.dispatch('product/clearFilters');      
      this.$store.dispatch('product/addFilter',{no_weight:1});      
    },
    noPrice(){
      this.$store.dispatch('product/clearFilters');      
      this.$store.dispatch('product/addFilter',{no_price:1});      
    },
    noImage(){
      this.$store.dispatch('product/clearFilters');      
      this.$store.dispatch('product/addFilter',{no_main_image:1});      
    },
    noDescription(){
      this.$store.dispatch('product/clearFilters');      
      this.$store.dispatch('product/addFilter',{no_description:1});      
    }
  },
}
</script>

<style>

</style>