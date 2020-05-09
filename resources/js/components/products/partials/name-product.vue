<template>
<div>
  <!-- Input -->
  <span v-if="pEdit">    
    <!-- Label -->
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text" :for="name+'-product-input'">Название</label>
      </div> 
      <!-- Input -->
      <input v-model="value" :id="name+'-product-input'" type="text" class="form-control">
    </div>
  </span>
  <!-- View -->
  <span v-else class="product-name">
    <strong>{{value}}</strong>
  </span> 
</div>
</template>

<script>
export default {
props: ['p-edit','p-value'],
model: {event: 'blur'},
data(){return{
  name:"name",
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

<style scoped>
  .product-name{
    font-size: 16pt;
    line-height: 0;
  }
</style>