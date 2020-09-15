<template>
  <div class="checkout-address checkout-address-gift">

    <div class="checkout-title">Адрес</div>

    <div class="form-group">
      <checkout-input :name="'addressStreet'" :placeholder="'Улица'" />
    </div>

    <div class="form-group d-flex form-group-multi">
      <checkout-input :name="'addressNumber'" :placeholder="'Дом'" />
      <checkout-input :name="'addressApart'" :placeholder="'Квартира'" />
      <checkout-input :name="'addressPorch'" :placeholder="'Подъезд'" />
    </div>


  </div>
</template>

<script>
export default {
}
</script>

<style>

</style>