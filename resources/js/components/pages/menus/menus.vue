<template>
  <div>
    <gruzka-navbar></gruzka-navbar>  
    <pages-navbar></pages-navbar>  
 
    <div class="container-fluid">
      <!-- Title -->
      <h1>Меню</h1>

      <menu-add></menu-add>

      <!-- List -->
      <juge-list :data="'menu'"></juge-list>
      
    </div>


  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>