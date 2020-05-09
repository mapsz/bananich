<template>  
  <span>

    <!-- Select -->
    <select v-if="input.type == 'select'" v-model="value" class="juge-form-input">
      <option v-for='(item,x) in input.list' :key='x' :value="item.id">{{item.name}}</option>
    </select> 

    <!-- Data -->
    <span v-else-if="input.type == 'date'">
      <flat-pickr v-model="date" :config="dateConfig"></flat-pickr>
    </span>

    <!-- File -->
    <file-upload 
      v-else-if="input.type == 'file'"
      v-model="value"   
      :file-type="input.fileType" 
    />

    <!-- Simple -->
    <input          
      v-else
      :id="input.name + '-input'"
      v-model="value"
      :name="input.name"      
      :type="input.type == undefined ? 'text' : input.type" 
      :required="input.required != undefined && input.required ? true : false"
      class="juge-form-input" 
      :aria-describedby="input.name + '-info'"
    >
    
  </span>  
</template>

<script>
export default {
props: ['input'],
model: {event: 'blur'},
data(){return{  
  value:null,
  dateConfig:datePickerConfig,
  dateFormat:'DD.MM.YYYY',
  date:null,
}},
watch: {
  value: function(){this.$emit('blur', this.value);},
  date:  function(a,b){this.value = moment(a,this.dateFormat).format('YYYY-MM-DD')},
},
}
</script>

<style>

</style>