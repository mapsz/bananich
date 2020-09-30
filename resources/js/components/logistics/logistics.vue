<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <order-navbar></order-navbar>
  
  <div class="container-fluid">

    <!-- Title -->
    <h1>Логистика</h1>  

    <!-- List -->
    <div class="container-fluid" ref="orderList">
      <juge-list :data="'logistic'" />
    </div>

  </div>
  
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>