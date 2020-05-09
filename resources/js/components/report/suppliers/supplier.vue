<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <div class="supplier container-fluid">

    <h2>{{data.name}}</h2>
    <div class="row">

      <!-- Info -->
      <div class="supplier-info supplier-col col-4 m-2 p-2">
        <h4>Информация</h4>
        {{data}}
      </div>

      <!-- Products -->
      <div class="supplier-products supplier-col col-4 m-2 p-2">
        <h4>Продукты</h4>
        <!-- Add product -->
        <div class="mb-2">
          <h5>Добавить продукт:</h5>        
          <search-product @choose="addProduct"></search-product>
        </div>
        <hr>        
        <!-- Product List -->
        <div>
          <h5>Список продуктов:</h5>
          <!-- List -->
          <div v-for='(product,i) in products' :key='i' class="pb-3">

            <span v-if="product.id == editIdShow">
              <input v-model="editId" type="text">
              <button @click="doEditId(product.id)" class="btn btn-sm btn-outline-success">ok</button>
            </span>

            {{product.supplier_product_id}}
            {{product.name}}

            <button @click="removeProduct(product.id)" class="btn btn-sm btn-outline-danger mx-2 float-right">x</button>
            <button @click="editIdShow=product.id" class="btn btn-sm btn-outline-primary float-right">id</button>
          
          </div>          
          <!-- Empty -->
          <span v-if="products.length==0">cписок продуктов пуст 🤷‍♀️</span>
        </div>
      </div>

      <!-- History -->
      <div class="supplier-hisoty supplier-col col-3 m-2 p-2">
        <h4>История</h4>

        Тут что-то будет...

        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis quaerat quisquam dolorem obcaecati nihil labore, porro veniam doloremque magni tempore optio qui eaque, atque aperiam dignissimos deserunt fugiat sunt nam esse aspernatur, molestias impedit magnam. Labore, fuga blanditiis. Recusandae nostrum iure temporibus pariatur architecto harum eius quibusdam, fuga eaque ut.

      </div>

    </div>

  </div>

    
</div>
</template>

<script>
export default {
data(){return{
  id:this.$route.params.id,
  data:{},
  products:[],
  editIdShow:false,
  editId:"",
}},
async mounted(){
  await this.get();
  this.products = this.data.products;
},
methods:{
  async get(){
    let r = await this.jugeAx('/json/suppliers',{id:this.id});
    if(!r) return false;
    this.data = r;
  },
  async addProduct(product){
    let r = await this.jugeAx('/attach/supplier/product',{produt_id:product.id,supplier_id:this.id},'put');
    if(!r) return false;
    this.products = [product].concat(this.products);
  },
  async removeProduct(productId){
    let r = await this.jugeAx('/remove/supplier/product',{produt_id:productId,supplier_id:this.id},'delete');
    if(!r) return false;
    let i = this.products.findIndex(x => x.id == productId);
    this.products.splice(i, 1);
  },
  async doEditId(productId){
    let r = await this.jugeAx('/edit/supplier/product/id',
    {
      produt_id:productId,
      supplier_id:this.id,
      id:this.editId
    },'post');
    if(!r) return false;

    let i = this.products.findIndex(x => x.id == productId);
    this.products[i]['supplier_product_id'] = this.editId;
    this.editIdShow = false;
  }
},
}
</script>

<style scoped>
.supplier-col{
  border:1px solid gray;
  border-radius: 7px;
}
</style>