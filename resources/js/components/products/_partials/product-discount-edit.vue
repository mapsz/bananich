<template>
  <div>
    <h3>Скидка</h3>
    
    <div v-for='(inputs,i) in inputsList' :key='i' class="mb-2">
      <div class="mb-2">
        <form data-v-25ffc046="" class="juge-form">
          <template v-for='(input) in inputs'>
            <span class="juge-form-label-required" v-bind:key="input.name+i">
              <label :for="input.name+'-input'">
                {{input.caption}}
              </label>
            </span> 
            <span v-bind:key="input.name+i">
              <input  :id="input.name+'-input'" :name="input.name" type="number" class="juge-form-input">
            </span>  
          </template>     
        </form>
      </div>
    </div>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  inputsSave:[],
  input:[
    {
      name:'discount_price',
      caption:'Цена с скидкой',
      type:"number",
    },
    {
      name:'quantity',
      caption:'Количество',
      type:"number",
      value:0,
    },
    {
      name:'type',
      caption:'Тип',
      type:"number",
      value:1,
    },
  ],
  errors:false,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
  inputsList:function(){
    if(this.product.discounts == undefined) return [];    
    let inputs = [];
    $.each(this.product.discounts , ( k, v ) => {
      console.log(v);
      let put = [
        {
          name:'discount_price',
          caption:'Цена с скидкой',
          type:"number",
          value:parseInt(v.discount_price),
        },
        {
          name:'quantity',
          caption:'Количество',
          type:"number",
          value:v.quantity,
        },
        {
          name:'type',
          caption:'Тип',
          type:"number",
          value:v.type,
        }
      ];


      inputs.push(put);

    });
    
    return inputs;
  }
},
methods:{
  postSettings(a){
    console.log(a);
  }
},
}
</script>

<style>

</style>