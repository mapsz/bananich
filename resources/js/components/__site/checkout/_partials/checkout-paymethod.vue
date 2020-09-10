<template>
<div class="col-md-6 mb-4">
  <div class="checkout-title">Способ оплаты</div>
  <div class="form-radio">
    <input v-model="paymethod" class="custom-radio" type="radio" id="pay-1" name="pay" value="Наличные">
    <label for="pay-1">Наличные</label>
  </div>
  <div class="form-radio">
    <input v-model="paymethod" class="custom-radio" type="radio" id="pay-2" name="pay" value="Картой курьеру">
    <label for="pay-2">Картой курьеру</label>
  </div>
  <div class="form-radio">
    <input v-model="paymethod" class="custom-radio" type="radio" id="packaging-3" name="pay" value="По банковским реквизитам">
    <label for="pay-3">По банковским реквизитам</label>
  </div>
</div>  
</template>

<script>
export default {
  model: {event: 'blur'},
  data(){return{
    paymethod:{}
  }},
  watch: {
    paymethod: {handler:function(){this.$emit('blur',this.paymethod);},deep:true}
  },
}
</script>

<style>

</style>