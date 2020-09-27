<template>
  <a :href="'/admin/confirm/'+data.id">
    <font-awesome-icon 
      class="text-primary" 
      icon="check-square" 
      size="2x"
    />
  </a>
</template>

<script>
export default {
  props: ['data'],

}
</script>

<style>

</style>