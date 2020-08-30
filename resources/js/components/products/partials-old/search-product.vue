<template>
<div>
  <!-- search product -->
  <form class="" @submit.prevent="doSearch()">
    <div class="input-group input-group-sm"  style="width: auto;">
      <input v-model="search" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Введите название или ID продукта">
      <div class="input-group-append">        
        <button type="submit" class="btn btn-primary">
          <font-awesome-icon icon="search" />
        </button>      
      </div>    
    </div>
  </form>  

  <!-- List -->
  <div v-if="showList" class="product-list">
    Рузультат поиска:
    <button @click="showList=false" class="btn btn-sm btn-outline-danger float-right">x</button>
    <hr>
    <div @click="choose(product)" v-for='(product,i) in products' :key='i' class="search-product">
      {{product.id}}
      {{product.name}}
    </div>
    <div v-if="products.length==0">
      Ничего не найдено 🙈
    </div>
  </div>


</div>
</template>

<script>
export default {
data(){return{
  search:"",
  showList:false,
  products:[],
}},
mounted(){
  // this.search = "гурц";
  // this.doSearch();
},
methods:{
  async doSearch(){
    let r = await this.jugeAx('/json/products',{search:this.search, archive:true,});
    if(!r) return;
    this.products = r;
    this.showList = true;
  },
  choose(product){
    this.$emit('choose',product);
    this.search="";
    this.showList=false;

  }
},
}
</script>

<style scoped>
  .product-list{
    background-color: white;
    position: absolute;
    border: 1px solid gray;
    border-radius: 0 0 5px 5px;
    padding: 10px;
  }
  .search-product{
    margin-bottom: 5px;
    cursor: pointer;
  }
  .search-product:hover{
    color: green;
    text-decoration: underline;  
  }
</style>