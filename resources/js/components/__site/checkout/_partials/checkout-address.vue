<template>
  <div class="checkout-address checkout-address-gift">

    <div class="checkout-title">Адрес</div>

    <div class="form-group">
      <input v-model="street" class="form-input" placeholder="Улица" type="text">
    </div>

    <div class="form-group d-flex form-group-multi">
      <input v-model="number" class="form-input" placeholder="Дом" type="text">
      <input v-model="apart" class="form-input" placeholder="Квартира" type="text">
      <input v-model="porch" class="form-input" placeholder="Подъезд" type="text">
    </div>


  </div>
</template>

<script>
export default {
model: {event: 'blur'},
data(){return{
  street:'',
  number:'',
  apart:'',
  porch:'',
}},
watch: {
  street: function(){this.$emit('blur', {street:this.street, number:this.number, apart:this.apart, porch:this.porch});},
  number: function(){this.$emit('blur', {street:this.street, number:this.number, apart:this.apart, porch:this.porch});},
  apart: function(){this.$emit('blur', {street:this.street, number:this.number, apart:this.apart, porch:this.porch});},
  porch: function(){this.$emit('blur', {street:this.street, number:this.number, apart:this.apart, porch:this.porch});},
},
}
</script>

<style>

</style>