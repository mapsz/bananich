<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <order-navbar></order-navbar>

  <!-- <parse></parse> -->

  <orders-print></orders-print>

  <!-- Filter -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <juge-date-filter :model="model"></juge-date-filter>
    <id-filter :model="model"></id-filter>
  </div>
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <order-delivery-time-filter :model="model" />
    <order-status-filter  :model="model" />
    <search-filter  :model="model" />
  </div>

<!-- 
  TODO @@@
  наличие возврвтов/ 
  метод оплаты/ 
  водитель/  
-->

  <!-- List -->
  <div class="container-fluid" ref="orderList">
    <juge-list :data="model"></juge-list>
  </div>

</div>
</template>

<script>
export default {
  data(){return{
    model:'order',
  }},
}
</script>

<style>

</style>



