<template>
<div>
  <gruzka-navbar></gruzka-navbar>

  <!-- Menu -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <date-menu :p-active="true"></date-menu>
  </div>
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <time-menu></time-menu>
    <search-menu></search-menu>
  </div>

  <!-- List -->
  <div class="container-fluid" ref="orderList">
    <list-table :model="'confirm'" :p-data-model-name="'orders'"></list-table>
  </div>

</div>
</template>

<script>
export default {

}
</script>

<style>

</style>