<template>
<div class="col-md-6 mb-4">
  <div class="checkout-title">Выбор упаковки</div>
  <div class="form-radio">
    <input v-model="container" class="custom-radio" type="radio" id="packaging-1" name="packaging" value="Стандарт (ящик)">
    <label for="packaging-1">Стандарт (ящик)</label>
  </div>
  <div class="form-radio">
    <input v-model="container" class="custom-radio" type="radio" id="packaging-2" name="packaging" value="Крафт коробка">
    <label for="packaging-2">Крафт коробка <span> (+100р)</span></label>
  </div>
  <div class="form-radio">
    <input v-model="container" class="custom-radio" type="radio" id="packaging-3" name="packaging" value="Крафт пакет">
    <label for="packaging-3">Крафт пакет <span> (+100р)</span></label>
  </div>
</div>  
</template>

<script>
export default {
  model: {event: 'blur'},
  data(){return{
    container:{}
  }},
  watch: {
    container: {handler:function(){this.$emit('blur',this.container);},deep:true}
  },
}
</script>

<style>

</style>