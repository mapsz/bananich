<template>
  <div>
    <h3>Скидка</h3>
    <juge-form :inputs="inputs" :errors="errors" @submit="postSettings"></juge-form>


  </div>
</template>

<script>
export default {
data(){return{
  inputs:[
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
methods:{
  postSettings(){
    console.log('...');
  }
},
}
</script>

<style>

</style>