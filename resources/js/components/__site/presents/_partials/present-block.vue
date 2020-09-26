<template>
  <div class="d-flex">    

    <!-- Image -->
    <div class="cart-bonuse-ico" style="align-self: center;">
      <a href="/presents"><img src="image/icons/gift.svg" alt="Present"></a>
    </div>

    <!-- Choose present -->
    <a 
      v-if="
        (
          cart.presents == undefined || 
          cart.presents[0] == undefined
        ) &&
        cart.pre_price >= presentSettings.present_s 

      " 
      href="/presents" class="url mt-2 mt-sm-3"
    >
      Выбери свой подарок
    </a>

    <!-- Info -->
    <div class="checkout-info-text">      
      <!-- Product -->
      <div v-if="cart.presents != undefined && cart.presents.length>0" class="d-flex align-items-center">
        <img :src="product.mainImage" alt="" style="width:50px; border-radius: 7px; margin: 0px 5px;">
        <span>{{product.name}}</span>
      </div>
      <!-- Stimulate -->
      <div 
        v-if="cart.pre_price < presentSettings.present_s"
        class=""
      >
        <span>Закажите еще на {{presentSettings.present_s - cart.pre_price}}р и получите подарок!</span>
        <a href="/" class="mt-2 url">Докупить</a>
      </div>

    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      presentSettings:'presents/getSettings',
      products:'presents/getProducts',
      product:'product/getOne'
    }),
  }, 
  watch: {
    cart: {
      handler: function (val, oldVal) {
        
        this.clearFilters();
        this.getProduct();
      },
      deep: true
    }
  },
  mounted(){
    this.getProduct();
    this.fetchPresents();   
  },
  methods:{
    ...mapActions({
      'fetchCart':'cart/fetch',
      'fetchPresents':'presents/fetch',
      'fetchProduct':'product/fetchOne',
      'clearFilters':'product/clearFilters',
    }),
    getProduct(){
        if(this.cart.presents != undefined && this.cart.presents[0] != undefined){
          this.fetchProduct(this.cart.presents[0].product_id);
        }
    }
  }

}
</script>

<style>

</style>