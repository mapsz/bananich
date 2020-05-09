<template>
<div>
  <!-- Name -->
  <div class="input-group input-group-sm my-2">
    <b>{{pItem.name}}</b> 
  </div> 
  <!-- Comment -->  
  <div class="input-group input-group-sm my-2"> 
    <div class="input-group-prepend">
      <span class="input-group-text">Комментарий</span>
    </div>
    <input v-model="item.comment" type="text" class="form-control">
  </div>  
  <!-- Quantity -->
  <div class="input-group input-group-sm my-2">
    <div class="input-group-prepend">
      <span class="input-group-text">Количество ({{pItem.gram_sys}} за шт)</span>
    </div>
    <input v-model="item.quantity" type="text" class="form-control">
  </div>
  <!-- Price -->
  <div class="input-group input-group-sm my-2">
    <div class="input-group-prepend">
      <span class="input-group-text">Цена за {{item.quantity}} шт</span>
    </div>
    <input v-model="item.price" type="text" class="form-control">
  </div>
  <!-- Price per unit -->
  <div class="input-group input-group-sm my-2">
    <div class="input-group-prepend">
      <span class="input-group-text">Цена за 1 шт</span>
    </div>
    <span class="form-control" style="cursor: no-drop;">{{pricePerUnit}}</span>
  </div>  
  <!-- Discounts -->
  <div v-if="item.product != undefined && item.product.discounts.length > 0" class="item-discounts my-2">
    <div class="item-discount-title">Акции:</div>
    <div 
      v-for="discount in item.product.discounts" 
      :key="discount.id" 
      class="d-flex justify-content-between align-items-center my-1 mx-2"
      :class="isDiscountActive(discount.id) ? 'text-success' : 'text-muted'"
    >
      <span>Кол-во:{{discount.quantity}} </span>
      <span>₽{{discount.discount_price}} </span>
      <span>Дата:{{discount.created_at}} </span>
      <!-- discount actions -->
      <span>
        <button v-if="!isDiscountActive(discount.id)" @click="addDiscount(discount.id)" class="btn btn-sm btn-success">+</button>
        <button v-else @click="removeDiscount(discount.id)" class="btn btn-sm btn-danger">X</button>
      </span>
    </div>
  </div>   
  <!-- Final price -->
  <div v-if="item.product != undefined && item.product.discounts.length > 0" class="input-group input-group-sm my-2">
    <div class="input-group-prepend">
      <span class="input-group-text">Цена с учетом скидок</span>
    </div>
    <span class="form-control" style="cursor: no-drop;">{{finalPrice}}</span>
  </div>  
  <!-- Actions -->
  <div class="d-flex justify-content-around">
    <!-- Save -->
    <button @click="editItem()" class="mb-3 btn btn-sm btn-success">
      Сохранить
    </button>      
    <!-- Delete -->
    <button @click="deleteItem()" class="mb-3 btn btn-sm btn-danger">
      Удалить
    </button>  
  </div>
</div>  
</template>

<script>
export default {
  props: ['p-item','p-used-discount'],
  data(){return{
    item:this.pItem,
  }},
  computed:{
    pricePerUnit: function(){
      return this.item.price / this.item.quantity;
    },
    finalPrice: function(){      
      let priceDiff = 0;
      $.each(this.pUsedDiscount, ( k, v ) => {
        if(this.item.quantity > v.quantity){
          priceDiff += (this.pricePerUnit - v.discount_price) * v.quantity;
        }else{
          priceDiff += (this.pricePerUnit - v.discount_price) * this.item.quantity;
        } 
      });
      return this.item.price - priceDiff;
    },    
  },
  methods:{
    async deleteItem(){
      let r = await this.jugeAx('/item', {itemId:this.pItem.id}, 'delete');
      if(!r) return;
      this.$emit('item-deleted',this.pItem.id);
    },
    async editItem(){
      let data = {
        itemId:   this.item.id,
        comment:  this.item.comment,
        price:    this.item.price,
        quantity: this.item.quantity,
      }

      let r = await this.jugeAx('/item', data, 'post');
      if(!r) return;

      tsuccess();
    },
    async removeDiscount(id){
      let r = await this.jugeAx('/discount/remove', {productId:this.item.product_id,orderId:this.item.order_id}, 'delete');
      if(!r) return;
      this.$emit('discount-edited',r);      
    },
    async addDiscount(id){
      let r = await this.jugeAx('/discount/add', {discountId:id, orderId:this.item.order_id}, 'put');
      if(!r) return;
      this.$emit('discount-edited',r);
    },
    isDiscountActive(id){
      return this.pUsedDiscount.findIndex(x => x.id == id)  > -1;
    },
  },

}
</script>

<style scoped>
  .item-discounts{
    border: 1px #ced4da solid;
    border-radius: 5px; 
  }
  .item-discount-title{
    padding: 0.25rem 0.5rem;
    background-color: #e9ecef;
    width: fit-content;
    border: 1px solid #ced4da;
    border-top: 0px;
    border-left: 0px;
    font-size: 0.7875rem;
    line-height: 1.5;
    border-radius: 0.2rem;    
    color: #495057;
  }
</style>