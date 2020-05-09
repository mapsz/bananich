<template>
  <div>
    <!-- Search -->
    <form class="mb-2" @submit.prevent="doSearch()">
      <div class="input-group input-group-sm"  style="width: auto;">
        <input v-model="search" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Введите название или ID продукта">
        <div class="input-group-append">        
          <button @click="doSearch()" class="btn btn-primary" type="button">
            <font-awesome-icon icon="search" />
          </button>      
        </div>    
      </div>
    </form>
    <!-- list -->
    <div>
      <div v-for="product in products" :key="product.id" class="add-item px-2 d-flex justify-content-between">
        <div style="flex:99">
          <div class="item-info  d-flex justify-content-between" >
            <!-- Name -->
            <span><b>{{product.name}}</b></span>        
            <span>
              <!-- unit -->
              <span>{{product.unit_sys ? '('+product.unit_sys+')' : ''}}</span>
              <!-- price -->
              <span>{{parseInt(product.price)}}</span>
            </span>
          </div>
          <div v-for="archive in product.archive" :key="archive.id" class="item-archive  d-flex justify-content-between" >
            <!-- date -->
            <span>{{archive.archive_at}}</span>
            <span>
              <!-- unit -->
              <span>{{archive.unit_sys ? '('+archive.unit_sys+')' : ''}}</span>
              <!-- price -->
              <span>{{parseInt(archive.price)}}</span>
            </span>
          </div>
        </div>
        <div style="flex:1">
          <!-- add button -->
          <button @click="putItem(product.id)" class="btn btn-sm btn-success m-1">+</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['p-order-id'],
  data(){return{
    search:null,
    products:[],
  }},
  methods:{
    async doSearch(){
      let r = await this.jugeAx('/json/products',{search:this.search, archive:true,});
      if(!r) return;
      this.products = r;
    },
    async putItem(id){
      let r = await this.jugeAx('/order/item',{orderId:this.pOrderId,productId:id},'put');
      if(!r) return;
     
      if(r.order_id != undefined && r.order_id == this.pOrderId){
        this.$emit('item-added',r);
      }
      
    }
  },
}
</script>

<style scoped>
  .add-item{
    border-bottom:1px solid gray;
  }
  .add-item:last-child{
    border-bottom:0px;
  }
</style>