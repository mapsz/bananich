<template>
  <div class="row">
    <div class="col-md-8">
      <div class="checkout-title">Комментарий к заказу</div>
      <div class="form-group">
        <checkout-input :name="'comment'" :placeholder="'Ваш комментарий'" :type="'textarea'" v-model="value"/>
      </div>
    </div>
  </div> 
</template>

<script>
export default {
model: {event: 'blur'},
data(){return{
  value:"",
}},
watch: {
  value: function(){
    this.$emit('blur', this.value);
  },
},
}
</script>

<style>

</style>