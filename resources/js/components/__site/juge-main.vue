<template>
  <div :class="isX?'page-x':''">
    <site-header />
      <template functional>

        <slot/>

      </template>
    <site-footer />
  </div>
</template>

<script>
export default {
data(){return{
  isX:isX,
}},

}
</script>

<style>
.page-x{
  background: #FAFAFA;
}
</style>