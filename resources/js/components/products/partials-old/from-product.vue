<template>
<div class="product-from">
  <!-- Input -->
  <span v-if="pEdit">    
    <!-- Label -->
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text" for="from-product-input">Страна</label>
      </div> 
      <!-- Input      -->
      <input v-model="value" id="from-product-input" type="text" class="form-control">
      <!-- Button -->
      <!-- <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button">Button</button>
      </div> -->
    </div>
  </span>
  <!-- View -->
  <span v-else>
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
  this.value = JSON.parse(JSON.stringify(this.pValue));;
},
watch: {
  value: function(){this.$emit('blur', this.value);},
},
}
</script>

<style>

</style>