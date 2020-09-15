<template>
<div class="col-md-6 mb-4">
  <div class="checkout-title">Способ оплаты</div>
  <checkout-input :name="'payMethod'" :type="'radio'" 
    :list="[
      {value:'cash',caption:'Наличные'},
      {value:'cart',caption:'Картой курьеру'},
      {value:'transfer',caption:'По банковским реквизитам'}
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