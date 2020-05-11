<template>
<div>
  <gruzka-navbar></gruzka-navbar>

  <parse></parse>

  <orders-print></orders-print>

  <!-- Menu -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <date-menu :p-active="true"></date-menu>
  </div>
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <time-menu></time-menu>
    <status-menu></status-menu>
    <search-menu></search-menu>
  </div>

  <!-- List -->
  <div class="container-fluid" ref="orderList">
    <list-table :model="'order'"></list-table>
  </div>

</div>
</template>

<script>
export default {
  //
}
</script>

<style>

</style>



