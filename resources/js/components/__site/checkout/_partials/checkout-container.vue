<template>
<div class="col-md-6 mb-4">
  <div class="checkout-title">Выбор упаковки</div>  
  <checkout-input :name="'container'" :type="'radio'" 
    :list="[
      {value:'0',caption:'Стандарт (ящик)'},
      {value:'2',caption:'Крафт коробка (+100р за шт.)'},
      {value:'3',caption:'Крафт пакет (+100р за шт.)'}
    ]" 
  />
  <!-- TODO @@@ (+100р) gray -->
  <!-- 
  <div class="form-radio">
    <input v-model="container" class="custom-radio" type="radio" id="packaging-3" name="packaging" value="Крафт пакет">
    <label for="packaging-3">Крафт пакет <span> (+100р)</span></label>
  </div> 
  -->
</div>  
</template>

<script>
export default {
}
</script>

<style>

</style>