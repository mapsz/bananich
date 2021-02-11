<template>
  <div v-if="product != undefined && !notAloved" :id="'cart-input-'+product.id" class="to-cart-wrapper" :class="design == 'cart' ? 'cart-design' : ''">
    <!-- Numbers -->
    <form v-if="count > 0 || count === ''" @change.prevent="toCart()" class="to-cart-number">        
      <!-- Minus     -->
      <span @click="count--;toCart()" class="back to-cart-buttons" style="text-align: center;cursor: pointer;">
        <span class="to-cart-symbol">
          -
        </span>
      </span>
      <!-- Digit -->
      <input v-model="count" class="number" type="text">
      <!-- Plus -->
      <span @click="count++;toCart()" class="next to-cart-buttons" style="text-align: center;cursor: pointer;">        
        <span class="to-cart-symbol">
          +
        </span>        
      </span>
    </form>
    <!-- To cart -->
    <div v-else>
      <button @click="count=1;toCart()" class="to-cart"><img src="/image/cart.svg" alt="В корзину"></button>
      <button @click="count=1;toCart()" class="btn-yellow btn-thick to-cart-big d-none">В корзину</button>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  props: ['product','design'],
  data(){return{
    count:0,
    notAloved:false,
    isX:isX,
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
        if(this.item == undefined) return;
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
      if((parseInt(this.count) > parseInt(this.product.available_unit)) && (this.product.always_publish == undefined || this.product.always_publish == 0)){
        $('#cart-input-'+this.product.id).popover({content:'К сожалению на складе осталось всего '+this.product.available_unit+' единиц этого товара',placement:'top'})
        $('#cart-input-'+this.product.id).popover('show');
        this.count = this.product.available_unit;
        return;
      }

      //Edit cart
      let r = await this.editItem({id:this.product.id,'count':this.count});

      if(!r && ax.lastResponse.status == 422 && ax.lastResponse.data == "not available"){
        this.notAloved = true;
        this.count = 0;
        this.$emit('notAloved')
        return;
      }

      if(r){
        if(!localServer){
          if(isX) ym(72176563,'reachGoal','addtocart'); else ym(54670840,'reachGoal','addtocart');   
        } 
      }
    },
  },
}
</script>

<style>
.cart-design .to-cart-number{
  width: fit-content;
}
.cart-design .to-cart-buttons{  
  width:42px !important;
  height:40px !important;
  display: flex;
  justify-content: center;
  align-items: center;
}
.cart-design .back{
  border-radius: 30px 0px 0px 30px !important;
}
.cart-design .next{
  border-radius: 0px 30px 30px 0px !important;
}
.cart-design .number{
  height:40px !important;
  width:46px !important;
}
.cart-design .to-cart-symbol{
  font-size: 22px;
  padding-bottom: 5px;
}

.page-x .to-cart-buttons{
  background: #C4C7B9 !important;
  color:white;
}
.page-x .to-cart{
  background: #8AC2A7 !important;
  color:white;
}


</style>