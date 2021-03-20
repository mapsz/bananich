<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <div class="container-fluid">

    <!-- Filters -->
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <juge-date-filter :model="model"></juge-date-filter>
    </div>
    <div class="row m-3 mb-2 order-menu justify-content-between">      
      <product-category-filter :model="'item'"/>
      <order-delivery-time-filter :model="model" />
      <order-status-filter  :model="model" />
      <item-status-filter  :model="model" />
      <suppliers-filter :model="model" />
    </div>

    <!-- List -->
    <juge-list :data="model" />

  </div>
  

</div>
</template>

<script>
export default {
  data(){return{
    model:'item'
  }},
}
</script>

<style>

</style>



