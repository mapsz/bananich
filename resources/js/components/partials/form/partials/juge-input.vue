<template>  
  <span>

    <!-- Select -->
    <select v-if="input.type == 'select'" v-model="value" class="juge-form-input">
      <option v-for='(item,x) in input.list' :key='x' :value="item.id">{{item.name}}</option>
    </select> 

    <!-- Date -->
    <span v-else-if="input.type == 'date'">
      <flat-pickr v-model="date" :config="dateConfig"></flat-pickr>
    </span>

    <!-- File -->
    <div v-else-if="input.type == 'file'">      
      <file-upload        
        v-model="value"
        :file-type="input.fileType" 
        :max-file-count="input.fileMax" 
        :value="value"
      />
    </div>

    <!-- Checkbox -->
    <b-form-checkbox v-else-if="input.type == 'checkbox'"      
      v-model="value" 
      :name="input.name"
      :id="input.name + '-input'"
      :required="input.required != undefined && input.required ? true : false"
      switch
    ></b-form-checkbox>

    <!-- Text area -->
    <textarea v-else-if="input.type == 'textarea'" 
      v-model="value"
      :name="input.name"    
      :id="input.name + '-input'"
      cols="30" 
      rows="5"
      :required="input.required != undefined && input.required ? true : false"
    ></textarea>

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
  value:this.input.value,
  dateConfig:datePickerConfig,
  dateFormat:'DD.MM.YYYY',
  date:null,
}},
watch: {
  value: function(){this.$emit('blur', this.value);},
  date:  function(a,b){this.value = moment(a,this.dateFormat).format('YYYY-MM-DD')},
},
mounted(){
  if(this.input.type == 'checkbox'){
    if(this.value === 1 || this.value === '1') this.value = true;
  }
},
}
</script>

<style scoped>
  .image-button-delete{
    cursor:pointer;
  }
</style>