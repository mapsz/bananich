<template>
<div v-if="cart.firstOrder != undefined && cart.firstOrder === false" class="row">
  <div class="col-md-6">
    <div class="checkout-title">Подтверждение заказа</div>
    <checkout-input :name="'confirm'" :type="'radio'" 
      :list="[
        {value:'1',caption:'По звонку оператора'},
        {value:'0',caption:'Без звонка оператора'},
      ]" 
    />
  </div>  
</div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
computed:{
  ...mapGetters({user:'user/get',cart:'cart/getCart'}),
},
}
</script>

<style>

</style>