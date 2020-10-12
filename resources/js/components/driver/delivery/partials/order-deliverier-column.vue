<template>
<div>
  {{data.statuses[0].user.name}}
</div>
</template>

<script>
export default {
props: ['data'],
}
</script>

<style>

</style>