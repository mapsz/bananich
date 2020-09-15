<template>
<div class="col-md-6 mb-4">
  <div class="checkout-title">Подтверждение заказа</div>
  <checkout-input :name="'confirm'" :type="'radio'" 
    :list="[
      {value:'0',caption:'По звонку оператора'},
      {value:'1',caption:'Без звонка оператора'},
    ]" 
  />
</div>  
</template>

<script>
export default {
}
</script>

<style>

</style>