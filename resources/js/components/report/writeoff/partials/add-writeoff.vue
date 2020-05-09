<template>
<div class="goods-add">
  <div class="mb-3">
    <h3 class="d-inline-block">Списать</h3>
    <!-- Close -->
    <button @click="$emit('close')" class="btn btn-danger" style="float: right;">X</button>
  </div>

  <!-- Search product -->
  <search-product class="mb-3" @choose="setProduct"></search-product>

  <!-- Product -->
  <div class="mb-2">
    <h5>{{product.id}} {{product.name}}</h5>
  </div>

  <!-- Current count -->
  <div v-if="product" class="mb-2">
    Текущее количество: <b>{{productCount}}</b>
  </div>

  <!-- Form -->
  <div v-if="product">
    <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
  </div>

</div>
</template>

<script>
export default {
  data(){return{
    product:false,
    productCount:0,
    search:'',
    errors:[],
    inputs:[
      {
        name:'quantity',
        caption:'Количество',
        required:true,
      },
      {
        name:'date',
        caption:'Дата',
        type:"date",
        required:true,
      },
      {
        name:'comment',
        caption:'Комментарий',
      },
      {
        name:'photo',
        caption:'Фото',
        type:"file",
        fileType:"image/*",
      },
    ]
  }},
  methods:{
    async setProduct(product){
      this.product = product;
      this.getProductCount(product.id);
    },
    async getProductCount(id){
      let r = await this.jugeAx('/json/report',{id:id});
      if(!r) return;
      this.productCount = r.summary;
    },    
    async put(data){
      data.product_id = this.product.id;
      this.errors = [];

      let r = await this.jugeAx('/put/writeoff',data,'put');
      if(!r){
        if(this.lastResponse.status != undefined){
          if(this.lastResponse.status == 422){
            this.errors = this.lastResponse.data.errors;            
          }
        }   
        return;
      };        

      this.$emit('writeoff-success');

      //Refresh
      this.product = false;
      
    },    
  },
}
</script>

<style scoped>
  .goods-add {
      background-color: #e4f9e4;
      padding: 20px;
      border: 1px solid green;
      border-radius: 7px;
      margin: 10px 0px;
  }
</style>