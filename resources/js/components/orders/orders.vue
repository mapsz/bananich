<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <order-navbar></order-navbar>

  <!-- <parse></parse> -->

  <orders-print></orders-print>

  <!-- Filter -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <juge-date-filter :model="model"></juge-date-filter>
    <!-- <juge-id-filter :model="model" /> -->
  </div>
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <order-delivery-time-filter :model="model" />
    <order-status-filter  :model="model" />
    <!-- <juge-search-filter  :model="model" /> -->
  </div>

  <!-- List -->
  <div class="container-fluid" ref="orderList">
    <juge-list :data="model" :pages="true"></juge-list>
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



