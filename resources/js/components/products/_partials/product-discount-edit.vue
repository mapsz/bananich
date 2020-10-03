<template>
  <div>
    <h3>Скидка</h3>
    
    <juge-form v-if="inputList" :inputs="inputList" :errors="errors" @submit="postSettings" @click="edit=i"></juge-form>

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
  ],
  errors:false,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
  inputList:function(){
    if(this.product == undefined) return false;
    if(this.product.discounts == undefined) return false;
    if(this.product.discounts[0] == undefined) return [this.input];
    
    let input = [
      {
        name:'discount_price',
        caption:'Цена с скидкой',
        type:"number",
        value:this.product.discounts[0].discount_price
      },
      {
        name:'quantity',
        caption:'Количество',
        type:"number",
        value:this.product.discounts[0].quantity,
      },
    ];
    
    return input;
  }
},
methods:{
  postSettings(a){
    a.product_id = this.product.id;
    let r = ax.fetch('/product/discount/set', a , 'post');
    console.log(r);
  }
},
}
</script>

<style>

</style>