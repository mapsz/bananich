<template>
  <div>
    <a :href="'/driver/delivery/'+data.order_id">
      <button class="btn btn-primary">Оформить</button>
    </a>
  </div>
</template>

<script>
export default {
props: ['data'],

}
</script>

<style>

</style>