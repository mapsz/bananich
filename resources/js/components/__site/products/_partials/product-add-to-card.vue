<template>
  <div :id="'cart-input-'+product.id">
    <form v-if="count" @change="toCart()" class="to-cart-number">            
      <span @click="count--;toCart()" class="back" style="text-align: center;cursor: pointer;">-</span>
      <input v-model="count" class="number" type="text">
      <span @click="count++;toCart()" class="next" style="text-align: center;cursor: pointer;">+</span>
    </form>
    <button v-else @click="count=1;toCart()" class="to-cart"><img src="/image/cart.svg" alt="В корзину"></button>
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
    }
  },
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
    }), 
    item:function(){ 
      if(this.cart == undefined) return 0;
      if(this.cart.items == undefined) return 0;
      return this.cart.items.find(x => x.product_id == this.product.id);     
    }
  },
  mounted(){
    if(this.item != undefined && this.item.count != undefined){
      this.count = this.item.count;
    }
    
    $(function () {
      $('[data-toggle="out-of-stock"]').popover()
    })
  },
  methods:{    
    ...mapActions({
      'editItem':'cart/editItem',
    }),
    toCart(){
      console.log(this.count);
      console.log(this.product.available);
      console.log(this.count > this.product.available);

      // 

      if(parseInt(this.count) > parseInt(this.product.available) && this.product.always_publish == undefined){
        $('#cart-input-'+this.product.id).popover({content:'К сожалению на складе осталось всего '+this.product.available+' единиц этого товара'})
        $('#cart-input-'+this.product.id).popover('show');

        console.log(this.product.available);
        this.count = this.product.available;
        return;
      }
      // console.log(this.product.available);
      this.editItem({id:this.product.id,'count':this.count});
    },
  },
}
</script>

<style>

</style>