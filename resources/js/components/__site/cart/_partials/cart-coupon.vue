<template>

  <div>
    
    <div>
      <form  class="cart-promo" @submit.prevent="add()">
        <input v-model="coupon" type="text" placeholder="Ввести промокод" class="cart-promo-input">
        <button type="submit" class="cart-promo-btn">Применить</button>
      </form>
      
      <span v-for='(errorz,z) in errors' :key='z+"d"' class="juge-form-error">
        <div v-for='(error,j) in errorz' :key='j' style="color:tomato">
          {{error}}
        </div>    
      </span>

      <div v-if="cart.coupon != undefined" class="m-2">
        <div>Применен промокод: <span><b>{{cart.coupon.code}}</b></span></div>
        <div style="font-size:10pt;color:gray;">Если вы хотите вместо него применить другой промокод, просто введите его в поле выше</div>
        
      </div>

    </div>


  </div>
  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    coupon:'',
    errors:[],
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
    }),
  },
  methods:{
   ...mapActions({
      'fetchCart':'cart/fetch',
    }), 
    async add(){
      this.errors = [];

      let r = await ax.fetch('/coupon/cart' , {coupon:this.coupon},'put');

      //Catch errors
      if(!r){      
        if(ax.lastResponse.status == 422){
          this.errors = ax.lastResponse.data.errors;
          return;
        }
      }

      if(r){this.fetchCart()}
    }
  },

}
</script>

<style>

</style>