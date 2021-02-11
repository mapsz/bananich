<template>
<juge-main>
  <div :class="halloween?'halloween':''">   

    <main class="cart-page mb-5">
      <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active">Корзина</li>
          </ol>
        </nav>

        <div class="mt-4 mt-sm-0 title-page-wrapper">
          <h1 class="title-page">Корзина</h1>
        </div>

        <div class="row content-page">

          <div class="col-lg-8">
            <div v-if="cart.items != undefined && cart.items.length == 0">Корзина пуста!</div>

            <div v-if="cart.items != undefined && cart.items.length > 0" class="content">
              <cart-items />
              <button @click="cartReset()" class="url">Удалить все</button> 
            </div>

          </div>
          <div class="col-lg-4">
          <!-- <div class="col-lg-4 offset-lg-1"> -->
            <!-- Sitebar -->
              <div class="cart-sitebar">

                <template v-if="!isX">
                  <!-- Shipping -->
                  <delivery-block />

                  <!-- Bonuses -->
                  <div class="cart-bonuse">                  
                    <present-block />
                    <hr>
                    <!-- Bonus -->
                    <div v-if="user" class="mb-4">
                      <bonus-cart-block></bonus-cart-block>
                    </div>
                    <!-- Coupons -->
                    <cart-coupon />
                  </div>
                </template>

                <!-- Info -->
                <div>
                  <shared-order-numbers class="mb-4" v-if="isX"/>
                  <buy-info v-else/>
                </div>

                <!-- To checkout -->
                <template>
                  <!-- X bananich -->
                  <template v-if="isX">
                    <cart-buttons />
                  </template>                  
                  <!-- Normal bananich -->
                  <template v-if="!isX">
                    <!-- Min price -->
                    <span v-if="cart.min_summ > cart.pre_price"
                      style="    
                        color: red;
                        font-size: 14pt;
                      "
                    >
                      Минимальная сумма заказа {{cart.min_summ}}
                    </span>
                    <a v-else href="/checkout" class="btn btn-yellow btn-thick">Оформить заказ</a>
                  </template>
                </template>
                

                <div v-if="!isX && (user && !(settings.min_order > cart.pre_price) && cart.pre_price > 0)" class="cart-message">
                  <div class="cart-message-ico">
                    <img src="image/icons/bonus.svg" alt="Bonus">
                  </div>
                  <div  class="cart-message-text">
                    <span>За этот заказ вы получите {{bonusesToGet}} бонусов! </span> 
                    <div class="cart-message-date">
                      Успейте потратить за 21 день!
                      <!-- <div class="cart-message-time"><span>01.12.2020</span> I <span>18:10</span></div>
                      <span style="color:red; font-size:8pt">!!(дата\время неизвестно?)</span> todo @@@ -->
                    </div>
                  </div>
                </div>
              </div>
            <!-- Sitebar -->
          </div>
        </div>

        <div v-if="0 && isX && myOrder.id == undefined" class="row my-5">

          <div v-if="0 && cart && cart.items != undefined && cart.items.length > 0" class="announce-block mb-5">
            <div style="color:#da00ff">Что с этим блоком?</div>
             <!-- todo @@@ -->
            <b>Поздравляем!</b>
            <div>
              Вы собрали свой заказ на Neolavka, чтобы купить все по супер-ценам необходимо открыть закупку. Выберете план закупки:
            </div>
          </div>

          <div class="col-12">
            <shared-order-open-blocks />
          </div>
        </div>
      </div>
    </main>
  
  </div>
</juge-main>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    halloween:halloween,isX:isX,
    moment:moment,
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      settings:'settings/beautyGet',
      user:'user/get',
      myOrder:    'sharedOrder/getMyOrder',
    }),
    freeShipping: function(){
      return this.settings.free_shipping;     
    },
    bonusesToGet:function (){
      if(
        this.cart == undefined || 
        this.cart.final_summ  == undefined || 
        this.cart.shipping == undefined || 
        this.settings == undefined || 
        this.settings.bonus_multiplier == undefined 
      ) return false;
      return Math.round((this.cart.final_summ - this.cart.shipping) * parseFloat(this.settings.bonus_multiplier));
    },
    order(){
      if(this.user == undefined && !this.user) return false;
      if(!this.myOrder || this.myOrder.orders == undefined || this.myOrder.orders.length <= 0) return false;

      let order = this.myOrder.orders.find(x => x.customer_id == this.user.id);
      if(!order || order.id == undefined) return false
      return order;

    },
    confirm(){
      if(this.user == undefined && !this.user) return false;
      if(!this.myOrder || this.myOrder.orders == undefined || this.myOrder.orders.length <= 0) return false;

      let order = this.myOrder.orders.find(x => x.customer_id == this.user.id);
      if(!order || order.x_confirm == undefined) return false
      return order.x_confirm;    
    },
  },
  watch: {
    cart: {
      handler: async function (val, oldVal) {
        if(this.cart.items == undefined) return;
        if(val == oldVal) return;

        let ids = [];

        $.each(this.cart.items, ( k, v ) => {
          ids.push(v.product_id);
        });

        //Present
        if(this.cart.presents != undefined && this.cart.presents[0] != undefined){
          ids.push(this.cart.presents[0].product_id);
        }

        if(ids.length == 0) return;
        
        this.addFilter({ids});
        this.getProducts();
        this.clearFilters();

        return;
      },
      deep: true
    }
  },
  mounted(){
    //Trackers
    if(!localServer){
      if(isX) ym(72176563,'reachGoal','opencart'); else ym(54670840,'reachGoal','opencart');   
    } 
    // this.getSettings();
  },
  methods:{
   ...mapActions({
      'editItem':'cart/editItem',
      'cartReset':'cart/cartReset',
      'removeItem':'cart/removeItem',
      'getSettings':'settings/fetch',
      'getProducts':'product/fetchData',
      'addFilter':'product/addFilter',
      'clearFilters':'product/clearFilters',
    }),  
    getItem(id){
      return this.cart.items.find(x => x.product_id == id);
    },
    goToOrder(){
      location.href = '/shared/order/' + this.myOrder.link;
    },
  },
}
</script>

<style scoped>

  .cart-overweight{
    border-radius: 20px;
    padding: 28px 22px;
    margin-bottom: 16px;
    border: 1px solid #e7dfdc;    
  }

  .cart-sitebar {
    margin-bottom: 20px !important;
  }

  .active {
      color: inherit !important;
      text-decoration: inherit !important;
      background-color: inherit !important;
  }

  .btn-yellow {
      background: #FBE214;
      border: 1px solid #FBE214;
      box-sizing: border-box;
      border-radius: 30px;
      color: #000000;
      width: 100%;
      height: 40px;
      line-height: 40px;
      font-size: 16px;
      text-align: center;
      cursor: pointer;
      display: inline-block;
      padding: 0 20px;
  }

  .halloween .title-page-wrapper{
    background-image: 
      url('/halloween/konfeta.png'),
      url('/halloween/wljapa.png')
    ;
    background-size: contain, contain;
    background-repeat: no-repeat,no-repeat;
    background-position: bottom right, bottom center;
  }

  .x-cart-do-button{
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Desktop */
  @media screen and (min-width: 992px){


  }

</style>