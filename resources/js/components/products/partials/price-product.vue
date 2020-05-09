<template>
<div class="product-prices">
  <!-- Input -->
  <span v-if="pEdit">    
    <!-- Label -->
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text" :for="name+'-product-input'">Цена</label>
      </div> 
      <div class="input-group-prepend">
        <label class="input-group-text" :for="name+'-product-input'">{{currency}}</label>
      </div> 
      <!-- Input -->
      <input v-model="value" :id="name+'-product-input'" type="number" class="form-control">
    </div>
  </span>
  <!-- View -->
  <span v-else>
    <span         
      class="product-regular-price"
      :class="sale ? 'is-sale' : ''"
    >
      {{currency}}{{regular}}
    </span>
    <span 
      v-if="sale"
      class="ml-2 product-sale-price"
    >
      {{currency}}{{sale}}
    </span>
  </span>
</div>
</template>

<script>
export default {
  props: ['p-edit','p-value'],
  model: {event: 'blur'},
  data(){return{ 
    name:"price",
    value:"",
    currency:window.currency,
    regular:0,
    sale:false,
  }},
  watch: {
    value: function(){this.$emit('blur', this.value);},
    pValue: function(){
      this.value = JSON.parse(JSON.stringify(this.pValue));
      this.regular = this.value;
    }
  },
  mounted(){
    //
  },  
}
</script>

<style scoped>
  /* Price */
  .product-prices{
    font-size: 16pt;
    font-weight: 600;    
  }
  .product-prices .is-sale{
    color: gray;
    text-decoration: line-through;
    font-weight: 100;    
  }
</style>