<template>
<div>

<!-- Button -->
<span @click="open()" style="cursor: pointer;">📝</span>

<div v-if="edit" class="modal" tabindex="-1" role="dialog" style="display:block;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Переучёт {{product.id}}</h5>
        <button @click="edit=false" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <!-- Image -->
          <div class="col-6">
            <img :src="product.mainImage" alt="">
          </div>
          <!-- info -->
          <div class="col-6">
            <h5>{{product.name}}</h5>
            <a :href="'/admin/product/' + product.id" target="_blank">Редактировать продукт </a>
            <p class="mt-3">Всего: <b>{{currentQuantity}}</b></p>
            <p class="mt-3">На складе: {{currentQuantity - currentCarQuantity}}</p>
            <p class="mt-3">Погружено: {{currentCarQuantity}} <span style="color:gray">({{currentCarOrders}})</span></p>
          </div>
        </div>
        <!-- input -->
        <div class="d-flex justify-content-center">
          <span>Количество: </span> 
          <input v-model="quantity" type="text">
        </div>
      </div>
      <div class="modal-footer">
        <button @click="save()" type="button" class="btn btn-primary">Save changes</button>
        <button @click="edit=false" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  
</div>
</template>

<script>
export default {
  props: ['data'],
  data(){return{
    edit:false,
    product:this.data,
    currentQuantity:0,
    currentCarQuantity:0,
    currentCarOrders:'',
    quantity:null,
  }},
  async mounted(){    
    //
  },
  methods:{
    open(){
      this.edit = true;
      this.getProductCount(this.product.id);
    },
    async getProductInCars(id){
      let params = {
        model:'item',
        itemStatus:300,
        status:[200,300,400,500],
        deliveryDate:{from:moment().subtract(6,'d').format('Y-M-DD'),to:moment().format('Y-M-DD')},
        productId:id
      };
      let r = await this.jugeAx('/juge',params);
      if(!r) return;
      this.currentCarQuantity = r.summ;
      this.currentCarOrders = r.orders;
    },
    async getProductCount(id){
      let r = await this.jugeAx('/json/report',{id:id});
      if(!r) return;
      this.currentQuantity = r.summary;

      this.getProductInCars(id);
    },  
    async save(){
      let r = await this.jugeAx('/stocktaking',{product_id:this.product.id,quantity:this.quantity},'put');
      if(!r) return;   
      this.currentQuantity = this.quantity;
      this.quantity = null;
    }
  },
}
</script>

<style>

</style>