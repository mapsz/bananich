<template>
  <div>
    <h3>Скидка</h3>
    
    <div v-for='(inputs,i) in inputsList' :key='i' >
      <juge-form :inputs="inputs" :errors="errors" @submit="postSettings" @click="edit=i"></juge-form>
    </div>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  edit:0,
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
    if(this.product.discounts == undefined) return [this.input];
    
    let inputs = [];
    $.each(this.product.discounts , ( k, v ) => {
      let put = [
        {
          name:'discount_price',
          caption:'Цена с скидкой',
          type:"number",
        },
        {
          name:'quantity',
          caption:'Количество',
          type:"number",
          value:v.discount_price,
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
    console.log(this.edit);
    console.log(a);
  }
},
}
</script>

<style>

</style>