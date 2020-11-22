<template>
  <div>
    <h3>Цена</h3>

    <div style="padding: 10px;">
      <juge-form v-if="inputsAllList" :inputs="inputsAllList" :errors="errors" @submit="postSettings"></juge-form>
    </div>

    <div style="background-color: #ffffd3;border: 1px solid #ff9900;padding: 10px;">
      <h5> <b>Бананыч</b> </h5>
      <juge-form v-if="inputList" :inputs="inputList" :errors="errors" @submit="postSettings"></juge-form>
    </div>

    <div style="margin-top:20px;background-color: rgb(222 222 222);border: 1px solid black;padding: 10px;">
      <h5> <b>X</b> </h5>
      <juge-form v-if="inputsXList" :inputs="inputsXList" :errors="errors" @submit="postSettings"></juge-form>
    </div>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  edit:0,
  inputsAll:[
    {
      name:'pack',
      caption:'Упаковка',
      type:"text",
    },
    {
      name:'transport',
      caption:'Транспорт',
      type:"text",
    },
  ],
  inputs:[
    {
      name:'price',
      caption:'Цена',
      type:"number",
    },
    {
      multi:true,        
      name:'discount',
      caption:'Cкидка',
      inputs:[
        {
          name:'discount_price',
          caption:'цена',  
          type:"number",
          width:'85px',
        },
        {
          name:'quantity',
          caption:'Количество',
          type:"number",
          width:'85px',
        },
      ]
    },
    {
      name:'charge',
      caption:'Наценка',
      type:"text",
    },
  ],
  inputsX:[
    {
      name:'price_x',
      caption:'Цена',
      type:"number",
    },
    {
      name:'charge_x',
      caption:'Наценка',
      type:"text",
    },
  ],
  errors:false,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
  inputList:function(){
    //No product
    if(this.product == undefined) return false;
    if(this.product.price == undefined) return false;
    
    //Data
    let inputs = this.addValueToInputs(JSON.parse(JSON.stringify(this.inputs)), this.product);
        
    {//Discount
      let i = false;
      i = inputs.findIndex(x => x.name == 'price');
      inputs[i].value = this.product.price;

      let j = false;
      if(this.product.discount != undefined){
        i = inputs.findIndex(x=> x.name == 'discount');
        j = inputs[i].inputs.findIndex(x=> x.name == "discount_price");
        inputs[i].inputs[j].value = this.product.discount.discount_price;
        j = inputs[i].inputs.findIndex(x=> x.name == "quantity");
        inputs[i].inputs[j].value = this.product.discount.quantity;
      }
    }
    
    return inputs;
  },
  inputsAllList:function(){
    //No product
    if(this.product == undefined) return false;
    if(this.product.price == undefined) return false;
    
    //Data
    let inputs = this.addValueToInputs(JSON.parse(JSON.stringify(this.inputsAll)), this.product);

    return inputs;
  },
  inputsXList:function(){
    //No product
    if(this.product == undefined) return false;
    if(this.product.price == undefined) return false;
    
    //Data
    let inputs = this.addValueToInputs(JSON.parse(JSON.stringify(this.inputsX)), this.product);

    return inputs;    
  }
},
methods:{
  postSettings(data){
    data.product_id = this.product.id;

    // if(data.discount_price == undefined) data.discount_price = (this.product.discount != undefined ? this.product.discount.discount_price : null);
    // if(data.quantity == undefined) data.quantity = (this.product.discount != undefined ? this.product.discount.quantity : null);

    // data.quantity = data.quantity == "" ? 0 : data.quantity;
    // data.discount_price = data.discount_price == "" ? 0 : data.discount_price;

    let r = ax.fetch('/product/discount/set', data , 'post');

    if(r) location.reload();
  },
  addValueToInputs(inputs,product){
    $.each(inputs, (k,input) => {
      $.each(product, (j,p) => {
        if(j == input.name){
          if(j == 'discount') return;
          inputs[k]['value'] = p; 
        }
      });
    });

    return inputs;
  }
},
}
</script>

<style>

</style>