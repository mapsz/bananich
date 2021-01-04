<template>
<juge-main>
  <div :class="halloween?'halloween':''">   

    <main class="cart-page">
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
                    <a href="/shared/order">
                      <button class="x-btn">Оформить коллективную закупку</button>                    
                    </a>
                  </template>
                  <!-- Normal bananich -->
                  <template v-else>
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
                

                <div v-if="user && !(settings.min_order > cart.pre_price) && cart.pre_price > 0" class="cart-message">
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
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      settings:'settings/beautyGet',
      user:'user/get',
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
      ym(54670840,'reachGoal','opencart');
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
    }
  },
}
</script>

<style scoped>

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

  .halloween .content-page{
    background-image: url(/halloween/kotel.png);
    background-size: 75px;
    background-repeat: no-repeat;
    background-position: bottom 0px left 20px;
  }

  @media screen and (max-width: 768px){

    .halloween .content-page{
      background-size: 25px !important;
    }
  }

</style>