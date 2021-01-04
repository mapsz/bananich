<template>
  <div class="row">
    <div class="col-md-8">
      <div v-if="design != 'x'" class="checkout-title">Комментарий к заказу</div>
      <div class="form-group">
        <checkout-input :name="'comment'" :placeholder="'Ваш комментарий'" :type="'textarea'" :no-cache="noCache" v-model="value"/>
      </div>
    </div>
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