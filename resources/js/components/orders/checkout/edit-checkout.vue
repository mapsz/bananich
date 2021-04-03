<template>
<div>
  <!-- Form -->
  <form id="order-checkout" @submit.prevent="doEdit()">
    <!-- Shipping -->
    <div class="form-group">
      <label for="order-checkout-shipping">Доставка</label>
      <input v-model="shipping" name="shipping" type="number" class="form-control" id="order-checkout-shipping" >
    </div>
    <!-- Bonus -->
    <div class="form-group">
      <label for="order-checkout-bonus">Бонусы</label>
      <input v-model="bonus" name="bonus" type="number" class="form-control" id="order-checkout-bonus" >
    </div>
    <!-- Save -->
    <button class="btn-success btn" type="submit">Сохранить</button>    
  </form>

  <!-- Extra Charges -->
  <hr>
  <order-edit-extra-charges />
  <hr>

</div>
</template>

<script>
export default {
props: ['p-shipping','p-bonus','p-order-id'],
data(){return{
  shipping:this.pShipping,
  bonus:this.pBonus,
}},
methods:{
  async doEdit(){
    let serialize = $('#order-checkout').serializeArray();    
    let r = await this.jugeAx('/order',{serialize:serialize,id:this.pOrderId},'post');
    this.$emit('checkout-edited');
  }
},
}
</script>

<style>

</style>