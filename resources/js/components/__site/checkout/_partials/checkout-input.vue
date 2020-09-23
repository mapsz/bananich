<template>

  <!-- Text area -->
  <textarea v-if="fType == 'textarea'" v-model="value" class="form-textarea" :placeholder="fPlaceholder" :name="inputName"></textarea>
  
  <!-- Radio -->
  <div v-else-if="fType == 'radio'" class="form-group">
    <div v-for='(input,i) in list' :key='i' class="form-radio">
      <input v-model="value" class="custom-radio" type="radio" :id="name+'-'+i" :value="input.value" :name="inputName">
      <label :for="name+'-'+i">{{input.caption}}</label>
    </div>
  </div>

  <!-- Chechbox -->
  <input v-else-if="fType == 'checkbox'" 
    v-model="value" 
    class="custom-checkbox" 
    type="checkbox" 
    :id="name" 
    :name="inputName" 
  >

  <!-- Simple -->
  <input v-else v-model="value" class="form-input" :placeholder="fPlaceholder" :type="fType" :name="inputName">

</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  model: {event: 'blur'},
  props: ['name', 'placeholder', 'type', 'list', 'checked'],
  data(){return{
    value:'',
    fType:'text',
    fPlaceholder:'',
    inputName:'checkout-'+this.name,
  }},
  computed:{...mapGetters({checkout:'checkout/get'}),},
  watch: {
    value: function(){
      this.$emit('blur', this.value);
      this.set({name:this.name, value:this.value});
    },
  },
  mounted(){
    //Set placeholder
    if(this.placeholder) this.fPlaceholder = this.placeholder;
    //Set type
    if(this.type) this.fType = this.type;
    //Value
    if(this.checkout[this.name]){
      this.value = this.checkout[this.name];
    } 
    else this.value = null;

    
    this.value = (this.checked != undefined && this.checked) ? true : false;

  },
  methods:{    
   ...mapActions({'set':'checkout/setValue'}),  
  },
}
</script>

<style>

</style>