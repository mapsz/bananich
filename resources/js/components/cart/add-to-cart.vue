<template>
<div class="add-to-cart d-flex">
  <!-- Quantity -->
  <div class="add-to-cart-quantity" style="width:120px">
    <input class="text-center" type="number" value="1"/>
  </div>
  <!-- button -->
  <span class="add-to-cart-button">
    <button class="ml-2 px-4 btn btn-outline-success">
      В Корзину
    </button>
  </span>        
</div>
</template>

<script>
export default {
  data(){return{ 
    toCart:{
      quantity:1,
    }
  }},
  mounted(){
    //Setup spinner
    $(".add-to-cart-quantity input").TouchSpin({
        min: 1,
        max: 99999,
        step: 1,
        boostat: 10,
        maxboostedstep: 10,
        buttondown_class: "btn btn-outline-dark",
        buttonup_class: "btn btn-outline-dark"
    });
    $(".add-to-cart-quantity input").change((e)=>{this.toCart.quantity = e.target.value;});
  },
}
</script>

<style>

</style>