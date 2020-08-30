<template>
<div class="goods-product-add">
  <div class="mb-3">
    <h3 class="d-inline-block">Добавить</h3>
    <!-- Close -->
    <button @click="$emit('close')" class="btn btn-danger" style="float: right;">X</button>
  </div>

  <!-- Search product -->
  <search-product class="mb-3" @choose="setProduct"></search-product>

  <!-- Product -->
  <div class="mb-2">
    <h5>{{product.id}} {{product.name}}</h5>
  </div>

  <!-- No supplier -->
  <span v-if="product && suppliers.length == 0" style="color:red">
    У данного продукта не найдено поставщиков! 🙈
  </span>

  <!-- Current count -->
  <div v-if="product && suppliers.length > 0" class="mb-2">
    Текущее количество: <b>{{productCount}}</b>
  </div>

  <!-- Form -->
  <div v-if="product && suppliers.length > 0" class="add-suppliers-form">
    <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
  </div>

</div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
  data(){return{
    product:false,
    productCount:0,
    suppliers:[],
    search:'',
    errors:[],
    inputs:[
      {
        name:'supplier_id',
        caption:'Поставщик',
        type:"select",
        list:[],
        required:true,
      },
      {
        name:'quantity',
        caption:'Количество',
        required:true,
      },
      {
        name:'price',
        caption:'Цена закупки(за шт/кг)',
        type:'number',
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
        name:'document',
        caption:'Документ',
        type:"file",
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
    ...mapActions({'fetch':'purchase/fetchData'}),
    async setProduct(product){
      //Get product suppliers
      let r = await this.jugeAx('/json/suppliers',{productId:product.id});
      if(!r) return;
      this.suppliers = r;    
      let i = this.inputs.findIndex(x => x.name == "supplier_id");
      this.inputs[i].list = this.suppliers;
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

      let r = await this.jugeAx('/put/purchase',data,'put');
      if(!r){
        if(this.lastResponse.status != undefined){
          if(this.lastResponse.status == 422){
            this.errors = this.lastResponse.data.errors;
          }
        }   
        return;   
      };        

      // this.$emit('add-success');
      this.fetch();

      //Refresh
      this.product = false;
      let i = this.inputs.findIndex(x => x.name == "supplier_id");
      this.inputs[i].list = this.suppliers;
      this.suppliers = [];
      
    },    
  },
}
</script>

<style scoped>
  .goods-product-add {
      background-color: #e4f9e4;
      padding: 20px;
      border: 1px solid green;
      border-radius: 7px;
      margin: 10px 0px;
  }
</style>