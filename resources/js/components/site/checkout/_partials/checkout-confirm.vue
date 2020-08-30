<template>
<div class="col-md-6 mb-4">
  <div class="checkout-title">Подтверждение заказа</div>
  <div class="form-radio">
    <input v-model="confirm" value="1" class="custom-radio" type="radio" id="verif-1" name="verif">
    <label for="verif-1">По звонку оператора</label>
  </div>
  <div class="form-radio">
    <input v-model="confirm" value="0" class="custom-radio" type="radio" id="verif-2" name="verif">
    <label for="verif-2">Без звонка оператора</label>
  </div>
</div>  
</template>

<script>
export default {
  model: {event: 'blur'},
  data(){return{
    confirm:{}
  }},
  watch: {
    confirm: {handler:function(){this.$emit('blur',this.confirm);},deep:true}
  },
}
</script>

<style>

</style>