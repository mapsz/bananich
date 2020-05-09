<template>
<div class="container-fluid">
  <!-- Navbar -->
  <gruzka-navbar></gruzka-navbar>

  <!-- Actions -->
  <div class="m-3">
    <confirm-actions :p-order-id="id"/>
  </div>
  <!-- Order -->
  <order></order>

</div>
</template>

<script>
export default {
  data() {
    return {
      id:this.$route.params.id,
    }
  },
}
</script>

<style>

</style>