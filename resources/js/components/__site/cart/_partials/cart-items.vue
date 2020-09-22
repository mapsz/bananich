<template>
  <div>

    <!-- <form action="">
      <div v-for='(item,i) in cart.items' :key='i' class="cart-item"> 

        <div>
          <div class="cart-name"><a :href="'/product/'+item.product_id" style="color:black">{{item.name}}</a></div>
          <span class="cart-weight">{{item.unit_digit * item.count}} {{item.unit_name}}</span>
        </div>
        
        <div class="cart-counter">
          <button @click="editItem({id:item.product_id, count:item.count-1})" class="back">-</button>
          <input class="number" :value="item.count" type="text">
          <button @click="editItem({id:item.product_id, count:item.count+1})" class="next">+</button>
        </div>
        

        <div class="cart-price">{{item.final_price}}</div>
        <div class="cart-points">+{{Math.round(item.final_price / 10)}}Б</div>
        <div @click="removeItem(item.product_id)" class="cart-remove"></div>
      </div>

    </form> -->


    <div class="cart-items">

      <div v-for='(item,i) in items' :key='i' class="item p-3 mb-3" style="position:relative">
        
        <span v-if="!item.present" @click="removeItem(item.product_id)" class="item-remove"></span>
        <div class="row">

          <div class="col-12 col-lg-7">
            <div class="d-flex">
              <div style="line-height: 1;">          
                <!-- Name -->
                <span class="font-weight-bold d-block pr-3">{{item.product != undefined ? item.product.name : ''}}</span>
                <!-- Count -->
                <span style="color:gray;font-size:11pt;">{{item.count}}</span>
              </div>
            </div>
          </div>
          
          <div class="col-12  col-lg-5 mt-3 mt-lg-0">
            <div class="d-flex justify-content-between" style="height: 100%;align-items: center;">
              <!-- Add to cart -->
              <span v-if="!item.present"><button><product-add-to-cart :product="products.find(x => x.id == item.product_id)"/></button></span>
              <!-- Bonus -->
              <span v-if="!item.present" style="color:gray;font-size:10pt;">{{'+'+Math.round(item.final_price / 10)+'Б'}}</span>
              <!-- Present -->
              <div v-else class="cart-bonuse-ico" style="align-self: center;width: 30px;"><a href="/presents"><img src="image/icons/gift.svg" alt="Present"></a></div>
              <!-- Price -->
              <span class="font-weight-bold pr-lg-3" >{{item.present ? 'Подарок' :item.final_price+'р'}}</span>
            </div>
          </div>

        </div>
      </div>


    </div>




  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      products:'product/get',
      cart:'cart/getCart',
      settings:'settings/beautyGet',
      user:'user/get',
    }),
    freeShipping: function(){
      return this.settings.free_shipping;     
    },
    items: function(){
      if(this.cart.items == undefined) return [];
      let items = JSON.parse(JSON.stringify(this.cart.items));

      //Present
      if(this.cart.presents != undefined && this.cart.presents[0] != undefined){
        let present = this.cart.presents[0];
        present['present'] = true;
        items.push(present);
      }

      $.each(items, ( k, v ) => {
        items[k]['product'] = this.products.find(x => x.id == v.product_id);        
      });

      return items;

    }
  },
  methods:{
   ...mapActions({
      'editItem':'cart/editItem',
      'removeItem':'cart/removeItem',
      'getSettings':'settings/fetch',
    }),  
    getItem(id){
      return this.cart.items.find(x => x.product_id == id);
    }
  },

}
</script>

<style scoped>
.cart-items .item-remove {  
  position: absolute;
  display: block;
  right: 10px;
  top: 20px;
  width: 14px;
  height: 14px;
  -webkit-transform: translate(0, -50%);
  transform: translate(0, -50%);
  font-size: 24px;
  background: url(/images/remove.svg?b11895a…) no-repeat center/cover;
  cursor: pointer;
}

.cart-items .item{
  /* background-color: gray; */
  background-color: #f8f8f8;
  border-radius: 20px;
  font-size: 12pt;
  margin-left:-15px;
  margin-right:-15px;
}


</style>