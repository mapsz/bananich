<template>
<div class="product-units">
  <span v-if="pEdit">    
    
    <div class="d-flex">
      <div class="input-group mb-3">
        <!-- Label -->
        <div class="input-group-prepend">
          <label class="input-group-text" :for="name+'-product-input'">{{caption}}</label>
        </div> 
        <!-- Input -->
        <input v-model="view" :id="name+'-product-input'" type="text" class="form-control" placeholder="500 гр.">
      </div>

      <div class="input-group mb-3">
        <!-- Label -->
        <div class="input-group-prepend">
          <label class="input-group-text" :for="name+'-product-input'"><font-awesome-icon icon="code" /></label>
        </div> 
        <!-- Input -->
        <input v-model="sys" :id="name+'-sys-product-input'" type="text" class="form-control" placeholder="0.5">
      </div>
    </div>

  </span>  
  <span v-else class="product-unit">
    {{view}}
  </span>
</div>
</template>

<script>
export default {
props: ['p-edit','pValue'],
model: {event: 'blur'},
data(){return{
  caption:"Единица",
  name:"unit",
  view:0,
  sys:0,
}},
  watch: {
    view: function(){this.$emit('blur', {view:this.view,sys:this.sys});},
    sys: function(){this.$emit('blur', {view:this.view,sys:this.sys});},
    pValue: function(){
      this.view = JSON.parse(JSON.stringify(this.pValue.unit));
      this.sys = JSON.parse(JSON.stringify(this.pValue.unit_sys));
    }
  },
}
</script>

<style>
</style>