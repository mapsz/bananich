<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <order-navbar></order-navbar>
  


  
  <div class="container-fluid" ref="orderList">

    <!-- Title -->
    <h1>Логистика</h1>  

    <!-- List -->
    <juge-date-filter :model="'logistic'"></juge-date-filter>
    <juge-list :data="'logistic'" />

  </div>

  
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>