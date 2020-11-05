<template>
<div>  
  <!-- Navbars -->
  <gruzka-navbar></gruzka-navbar>  
  <product-navbar></product-navbar>

  <div class="container-fluid">
    <!-- Title -->
    <h1>Весы</h1>

    <!-- Add -->
    <libra-add />

    <!-- List -->
    <juge-list :data="'libra'" :edit="true" :delete="true" />

  </div>



</div>
</template>

<script>
export default {

}
</script>

<style>

</style>