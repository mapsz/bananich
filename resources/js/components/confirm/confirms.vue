<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <order-navbar></order-navbar>

  <div class="container-fluid">

    <!-- Title -->
    <h1>Подтверждение заказов</h1>  
    
    <!-- Menu -->
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <juge-date-filter :model="'order'" :default="false"></juge-date-filter>
    </div>
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <order-delivery-time-filter :model="'order'" />
      <search-filter  :model="'order'" />
    </div>

    <!-- List -->
    <div class="container-fluid" ref="orderList">
      <juge-list :data="'order'" :keys="'confirm'" :disable-auto-fetch="true"/>
    </div>

  </div>



</div>
</template>

<script>
export default {
  mounted(){
    //Set filters
    this.$store.dispatch('order/addFilter',{status:[900,850,800,700]});
    //Fetch
    this.$store.dispatch('order/listFetch');
  }
}
</script>

<style>

</style>