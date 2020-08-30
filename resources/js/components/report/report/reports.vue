<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <div class="container-fluid">

    <!-- Filters -->
    <div class="my-2">
      <suppliers-filter :model="'report'"></suppliers-filter>
    </div>

    <!-- List -->
    <juge-list :data="'report'"></juge-list>
    
  </div>

</div>
</template>

<script>
export default {
}
</script>

<style>

</style>