<template>
<div class="row">
  <div class="col-md-6">
    <div class="checkout-title">Подтверждение заказа</div>
    <checkout-input :name="'confirm'" :type="'radio'" 
      :list="[
        {value:'0',caption:'По звонку оператора'},
        {value:'1',caption:'Без звонка оператора'},
      ]" 
    />
  </div>  
</div>  
</template>

<script>
export default {
}
</script>

<style>

</style>