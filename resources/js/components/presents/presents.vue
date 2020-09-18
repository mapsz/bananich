<template>
  <div>
    
    <gruzka-navbar></gruzka-navbar>    
    <product-navbar></product-navbar>

    <!-- Form -->
    <div class="container pt-3">

      <div class="row">

        <div class="col-6">
          <div class="row">
            <juge-form :inputs="inputs" :errors="errors" @submit="postSettings"></juge-form>
            <div>
              <div class="answer">{{settings.present_s}}</div>
              <div class="answer">{{settings.present_m}}</div>
              <div class="answer">{{settings.present_l}}</div>
              <div class="answer">{{settings.present_xl}}</div>
            </div>
          </div>
        </div>
        
        <div class="col-6">
          <search-product @choose="setProduct"/>
          <div v-if="toAdd">
            {{toAdd.name}}

            <div class="d-flex justify-content-between">
              <button @click="addProduct('s')" class="btn btn-primary" style="width:inherit">Добавить S</button>
              <button @click="addProduct('m')" class="btn btn-primary" style="width:inherit">Добавить M</button>
              <button @click="addProduct('l')" class="btn btn-primary" style="width:inherit">Добавить L</button>
              <button @click="addProduct('xl')" class="btn btn-primary" style="width:inherit">Добавить XL</button>
            </div>
          </div>

          <!-- Current presents list -->
          <ul>
            <li v-for='(product,i) in products' :key='i'>
              
              <!-- Delete -->
              <span @click="removeProduct(product.product_id, product.type)" style="cursor:pointer;">❌</span>
              <!-- Info -->
              <span>({{product.type}})</span>
              <span>{{product.product_id}}</span>
              <span>{{product.product.name}}</span>


            </li>
          </ul>

        </div>
      </div>

    </div>


  </div>
</template>

<script>
export default {
  data(){return{
    toAdd:false,
    products:[],
    settings:[],
    errors:[],
    inputs:[
        {
          name:'present_s',
          caption:'Минимальная сумма S',
          type:"number",
        },
        {
          name:'present_m',
          caption:'Минимальная сумма M',
          type:"number",
        },
        {
          name:'present_l',
          caption:'Минимальная сумма L',
          type:"number",
        },
        {
          name:'present_xl',
          caption:'Минимальная сумма XL',
          type:"number",
        },
      ]
  }},
  mounted(){
    this.getSettings();
    this.getProducts();
  },
  methods:{
    async getSettings(){
      this.settings = await ax.fetch('/present/settings');
    },
    async postSettings(data){
      let r = await ax.fetch('/settings',data,'post');
      this.getSettings();
    },
    async setProduct(product){
      this.toAdd = product;
    },
    async addProduct(type){
      let id = this.toAdd.id;
      let r = await ax.fetch('/admin/product/present',{id,type},'put');
      this.getProducts();
    },
    async removeProduct(id, type){
      let r = await ax.fetch('/admin/product/present',{id,type},'delete');
      location.reload();
    },
    async getProducts(){
      this.products = await ax.fetch('/product/present');
    }
  },
}
</script>

<style scoped>
  .answer {
      padding: 7px 0px;
  }
</style>