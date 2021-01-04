<template>
<div class="col-md-6 mb-4">
  <div class="checkout-title">Способ оплаты</div>
  <checkout-input :name="'payMethod'" :type="'radio'"  :no-cache="noCache" v-model="value" 
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
model: {prop: 'hidden',event: 'blur'},
props: ['design','hidden', 'no-cache'],
data(){return{
  value:"",
}},
watch: {
  value: function(){
    this.$emit('blur', this.value);
  },
  hidden: function(){
    this.value = this.hidden;
  }
},
async mounted() {
  this.value = this.hidden;
},
}
</script>

<style>

</style>