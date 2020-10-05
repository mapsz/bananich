<template>
  <div>
    <h3>Цена</h3>
    
    <juge-form v-if="inputList" :inputs="inputList" :errors="errors" @submit="postSettings" @click="edit=i"></juge-form>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  edit:0,
  inputs:[
      {
        name:'price',
        caption:'Стандартная',
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
        name:'x_price',
        caption:'ХЦена',
        type:"number",
      }
  ],
  errors:false,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
  inputList:function(){


    let inputs = JSON.parse(JSON.stringify(this.inputs));
    
    if(this.product == undefined) return false;
    if(this.product.price == undefined) return false;

    let i = false;
    i = inputs.findIndex(x=> x.name == 'price');
    inputs[i].value = this.product.price;

    let j = false;
    if(this.product.discount != undefined){
      i = inputs.findIndex(x=> x.name == 'discount');
      j = inputs[i].inputs.findIndex(x=> x.name == "discount_price");
      inputs[i].inputs[j].value = this.product.discount.discount_price;
      j = inputs[i].inputs.findIndex(x=> x.name == "quantity");
      inputs[i].inputs[j].value = this.product.discount.quantity;
    }
    
    return inputs;
  }
},
methods:{
  postSettings(data){
    data.product_id = this.product.id;

    if(data.discount_price == undefined) data.discount_price = (this.product.discount != undefined ? this.product.discount.discount_price : null);
    if(data.quantity == undefined) data.quantity = (this.product.discount != undefined ? this.product.discount.quantity : null);

    let r = ax.fetch('/product/discount/set', data , 'post');
    console.log(r);
    if(r) location.reload();
  }
},
}
</script>

<style>

</style>