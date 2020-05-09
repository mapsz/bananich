<template>
<div class="loader">
  <img src="/img/loader.svg">
</div>  
</template>

<script>
export default {

}
</script>

<style scoped>
  @keyframes bounce { 
    0% { transform: translateY(0); }
    100% { transform: translateY(-50px); }
  }
  .loader {
    animation: bounce 0.8s;
    animation-direction: alternate;
    animation-iteration-count: infinite;
  }
</style>