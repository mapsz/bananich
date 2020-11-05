<template>
  <div>
    <!-- Add -->
    <div class="p-3" style="max-width:400px;border:1px solid #c3c3c3; border-radius:7px">
      <h3>Добавить</h3>
      <!-- Search -->
      <search-product @choose="setProduct"></search-product>
      <!-- Inputs -->
      <div class="mt-2" v-if="product">
        <!-- Product -->
        <div class="mb-2">
          <b>
            <span v-if="product.id != undefined">{{product.id}}</span>
            <span v-if="product.name != undefined">{{product.name}}</span>
          </b>
        </div>
        <!-- Forms -->
        <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
      </div>
    </div>   
  </div>
</template>

<script>
export default {
data(){return{
  product:false,
  errors:[],
  inputs:[
    {
      name:'libra',
      caption:'Весы',
      type:"select",
      list:[{id:1,name:1+'(рыба)'},{id:2,name:2+'(сыпучка)'}],
      required:true,
    },
    {
      name:'button',
      caption:'Кнопка',
      type:"number",
      required:true,
    },
  ],
}},
methods:{
  setProduct(product){
    this.product = product;
  },
  async put(data){
    this.errors = [];
    data.product_id = this.product.id;
    //Fetch
    let r = await ax.fetch('/admin/libra',data,'put');
    // Error

    console.log(r);
    console.log(ax.lastResponse);


    if(!r){if(ax.lastResponse.status != undefined){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;}}return;};   

    location.reload();
  }
},
}
</script>

<style>

</style>