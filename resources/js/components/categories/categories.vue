<template>
<div>  
  <gruzka-navbar></gruzka-navbar>
  <div class="container-fluid">
    <!-- Title -->
    <h1>Категории</h1>
  
    <add-category></add-category>

    <!-- List -->
    <juge-list :data="'category'"></juge-list>
    
  </div>
</div>
</template>

<script>
export default {
}
</script>

<style>

</style>