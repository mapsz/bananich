<template>
<div>
  <h5>Описание:</h5>
  <!-- Input -->
  <div v-if="pEdit" class="form-group">
    <textarea v-model="value" class="form-control" id="description-product-input" rows="3"></textarea>
  </div>
  <!-- View -->
  <span v-else class="product-description">      
    {{value}}
  </span>  
</div>
</template>

<script>
export default {
props: ['p-edit','p-value'],
model: {event: 'blur'},
data(){return{
  value:"",
}},
mounted(){
  this.value = JSON.parse(JSON.stringify(this.pValue));
},
watch: {
  value: function(){this.$emit('blur', this.value);},
},
}
</script>

<style>

</style>