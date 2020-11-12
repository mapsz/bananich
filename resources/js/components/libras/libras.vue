<template>
<div>  
  <!-- Navbars -->
  <gruzka-navbar></gruzka-navbar>  
  <product-navbar></product-navbar>

  <div class="container-fluid">
    <!-- Title -->
    <h1>Весы</h1>

    <!-- Add / Sort -->
    <div class="row">
       <!-- Add -->
      <div class="col-4">
        <libra-add />
      </div>
      <!-- Sort -->
      <div class="col-4">
        <div style="display: flex; justify-content: center;">
          <button @click="sortByName()" class="btn btn-info">Сортировать по алфавиту</button>
        </div>        
      </div>  
      <!-- Status -->
      <div class="col-4">
        aaa
      </div>    
    </div>    

    <!-- List -->
    <juge-list :data="'libra'" :edit="true" :delete="true" />

  </div>



</div>
</template>

<script>
export default {
methods:{
  async sortByName(){
    let r = await ax.fetch('/admin/libra/sort',{},'post');
    location.reload();
  }
},
}
</script>

<style>

</style>