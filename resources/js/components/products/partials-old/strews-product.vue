<template>
<div class="d-none">
  <label>Сыпучка:</label>
  <!-- Input -->
  <div v-if="pEdit" class="form-group">
    <input v-model="value"  type="text" class="form-control">
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
  pValue: function(){this.value = JSON.parse(JSON.stringify(this.pValue));},
},
}
</script>

<style>

</style>