<template>
  <div v-if="product != undefined" :id="'cart-input-'+product.id">
    <form v-if="count > 0 || count === ''" @change.prevent="toCart()" class="to-cart-number">            
      <span @click="count--;toCart()" class="back" style="text-align: center;cursor: pointer;">-</span>
      <input v-model="count" class="number" type="text">
      <span @click="count++;toCart()" class="next" style="text-align: center;cursor: pointer;">+</span>
    </form>
    <div v-else>
      <button  @click="count=1;toCart()" class="to-cart"><img src="/image/cart.svg" alt="В корзину"></button>
      <button @click="count=1;toCart()" class="btn-yellow btn-thick to-cart-big d-none">В корзину</button>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  props: ['product'],
  data(){return{
    count:0,
  }},
  watch: {
    cart: {
      handler: function (val, oldVal) {
        if(this.item == undefined || this.item.count == undefined) return;
        this.count = this.item.count;
      },
      deep: true
    },
    product: {
      handler: function (val, oldVal) {
        if(this.product == undefined) return;
        this.count = this.item.count;
      },
      deep: true
    },
  },
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
    }), 
    item:function(){ 
      if(this.product == undefined) return 0;
      if(this.cart == undefined) return 0;
      if(this.cart.items == undefined) return 0;
      return this.cart.items.find(x => x.product_id == this.product.id);     
    }
  },
  mounted(){
    if(this.item != undefined && this.item.count != undefined){
      this.count = this.item.count;
    }
  },
  methods:{    
    ...mapActions({
      'editItem':'cart/editItem',
    }),
    async toCart(){
      //Chech out of stock
      if(parseInt(this.count) > parseInt(this.product.available) && this.product.always_publish == undefined){
        $('#cart-input-'+this.product.id).popover({content:'К сожалению на складе осталось всего '+this.product.available+' единиц этого товара',placement:'top'})
        $('#cart-input-'+this.product.id).popover('show');
        this.count = this.product.available;
        return;
      }

      //Edit cart
      let r = await this.editItem({id:this.product.id,'count':this.count});

      // console.log(r);

      //Pixel
      if(typeof fbq === 'function')
        fbq('track', 'AddToCart');
    },
  },
}
</script>

<style>

</style>