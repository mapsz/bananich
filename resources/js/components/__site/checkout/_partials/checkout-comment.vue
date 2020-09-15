<template>
  <div class="row">
    <div class="col-md-8">
      <div class="checkout-title">Комментарий к заказу</div>
      <div class="form-group">
        <checkout-input :name="'addressStreet'" :placeholder="'Ваш комментарий'" :type="'textarea'" />
      </div>
    </div>
  </div> 
</template>

<script>
export default {
}
</script>

<style>

</style>