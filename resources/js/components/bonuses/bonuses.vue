<template>
<div>
  
  <gruzka-navbar></gruzka-navbar>

  <!-- Add -->
  <add-bonus></add-bonus>

  <!-- List -->
  <div class="container-fluid" ref="orderList">
    <juge-list :data="'bonus'"></juge-list>
  </div>

</div>
</template>

<script>
export default {
  mounted(){    
    this.$store.dispatch('bonus/addFilter',{all_users:1});
  },
}
</script>

<style>

</style>