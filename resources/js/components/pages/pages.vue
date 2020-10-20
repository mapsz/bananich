<template>
  <div>
    <gruzka-navbar></gruzka-navbar>  
    <!-- <pages-navbar></pages-navbar>   -->
 
    <div class="container-fluid">
      <!-- Title -->
      <h1>Страницы</h1>

      <!-- Add -->
      <a href="/admin/page/add">
        <button class="btn btn-success">add</button>      
      </a>

      <!-- List -->
      <juge-list :data="'page'"></juge-list>
      
    </div>


  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>