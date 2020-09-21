<template>
  <div>
    <gruzka-navbar></gruzka-navbar>  
 
    <div class="container-fluid">
      <!-- Title -->
      <h1>Купоны</h1>

      <coupon-add></coupon-add>

      <!-- List -->
      <juge-list :data="'coupon'"></juge-list>
      
    </div>


  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>