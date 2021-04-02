<template>
  <juge-main>

    <main class="cart-page">
      <div class="container">
        <!-- Bread -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="/cart">Корзина</a></li>
            <li class="breadcrumb-item active">Оформление заказа</li>
          </ol>
        </nav>

        <!-- Title -->
        <div class="d-flex mt-4 mt-sm-0 title-page-wrapper">
          <a href="/cart" class="arrow-back"><img src="/image/arrow.svg" alt="arrow"></a>
          <h1 class="title-page">Оформление заказа</h1>
        </div>

        <!-- Content -->
        <div class="row content-page checkout-data">

          <!-- Inputs -->
          <div class="col-lg-6">
            <div class="content pb-0 mb-3">
              <checkout-contact class="checkout-div " v-model="data.contacts" />

              <checkout-login class="checkout-div" />

              <checkout-toother class="checkout-div" v-model="data.toOther" />
              
              <!-- Address -->
              <template>
                <div class="checkout-div">
                <!-- <div v-if="user" class="checkout-div"> -->
                  <div class=" checkout-address checkout-address-gift m-0">
                    <div class="col-12">
                      <div class="checkout-title">Адрес</div>                      
                      <choose-address v-model="data.jugeAddress"/>
                    </div>
                  </div>
                </div>
                <!-- <checkout-address v-else class="checkout-div"/> -->

                <p v-show="0">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Map
                  </button>
                </p>
                <div class="collapse" id="collapseExample">
                  <div class="card card-body">
                    <polygons v-show="1" @polygonsFind="setPolygons" :setMarker="choosedCoords" />
                  </div>
                </div>                
              </template>              
            
              <!-- Date / Time -->
              <checkout-x-date-time class="checkout-div" v-model="data.dateTime" :polygons="choosedPolygons"/>

              <!-- Container / Paymethod -->
              <div class="row checkout-div">
                <div class="col-12 col-lg-6">
                  <checkout-container v-model="data.container"/>
                </div>
                <!-- <div class="col-12 col-lg-6">
                  <checkout-paymethod v-model="data.paymethod"/>
                </div> -->
              </div>
              
              <checkout-confirm class="checkout-div" v-model="data.confirm"/>

              <checkout-comment class="checkout-div" v-model="data.comment"/>

            </div>
          </div>
          <!-- Numbers -->
          <div class="col-lg-5 offset-lg-1">
            <div v-if="isX">
              <shared-order-numbers class="mb-3"/>
              <checkout-agreements />
            </div>
          </div>          
          <!-- Buttons -->
          <div v-if="isX"  class="col-lg-12 mb-5">
            <juge-errors :errors="errors"/>
            <div class="d-flex justify-content-center">
              <button class="x-btn" @click="doOrder('x')">Оформить заказ</button>
            </div>              
          </div>
        </div>
      </div>
    </main>

  </juge-main>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
  data(){return{    
    isX:isX,
    halloween:halloween,
    data:{},
    errors:[],
    choosedPolygons:null,
  }},
  computed:{
    ...mapGetters({
      cart:     'cart/getCart',
      checkout: 'checkout/get',      
      user:     'user/get',
      addresses:'addresses/get',    
    }),
    choosedAddress(){
      if(this.data == undefined || this.data.jugeAddress == undefined) return false;
      if(this.addresses == undefined || this.addresses[0] == undefined) return false;

      let address = this.addresses.find(x => x.id == this.data.jugeAddress);
      return address;
    },
    choosedCoords(){
      if(this.choosedAddress.x == undefined || this.choosedAddress.y == undefined) return false;
      return {x:this.choosedAddress.x, y:this.choosedAddress.y};
    },
  },
  watch:{
    choosedAddress: function (val, oldVal) {
      console.log(val);
    },
  },
  mounted(){
    //Trackers
    if(!localServer){
      ym(54670840,'reachGoal','opencart');
      fbq('track', 'InitiateCheckout');
    } 
  },
  methods:{
    ...mapActions({
      'clean':'checkout/clean',
    }),
    async doOrder(type=false){
      //Refresh errors
      if(ax.lastResponse.data != undefined && ax.lastResponse.data.errors != undefined) ax.lastResponse.data.errors = [];
      this.errors = [];
      
      //Log
      let r = await ax.fetch('/order/log', {}, 'put');

      if(!r) return;

      let data = this.checkout;
      data.jugeAddress = this.data.jugeAddress;

      //Put      
      r = await ax.fetch('/order/put', {data,'cartId':this.cart.id,type,'polygons':this.choosedPolygons}, 'put');

      //Catch errors
      if(!r){      
        if(ax.lastResponse.status == 422){
          this.errors = ax.lastResponse.data.errors;
          return;
        }
      }

      if(r > 0){
        await ax.fetch('/order/log/success', {}, 'put');
        //Trackers
        // if(!localServer && !isX && ym != undefined){
        //   ym(54670840,'reachGoal','ordered');
        //   fbq('track', 'Purchase', {value: this.cart.final_summ, currency: 'RUB'});
        // } 
        // if(!localServer && isX && ym != undefined){
        //   ym(72176563,'reachGoal','orderplaced');
        // } 
        this.clean();
        // ax.fetch('/order/update/available', {id:r});
        // location.href ='/order-thanks';
      }        
    },
    setPolygons(ids){
      this.choosedPolygons = ids;
    },
  }
}
</script>

<style scoped>
  .checkout-div{
    border-bottom: 1px solid #fbe214;
    margin-bottom: 30px;
    padding-bottom: 30px;
  }
  .checkout-div:last-child{
    border-bottom: 0px solid #fbe214;
    margin-bottom: 0px;
    padding-bottom: 0px;
  }
  .page-x .checkout-div{
    border-color:#8ac2a7;
  }

  .title-page{
    margin-bottom: 20px !important;
  }

  .halloween .title-page-wrapper{
    background-image: 
      url('/halloween/tikva_listochik.png')
    ;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: bottom right 20px;
  }
  .checkout-address, .checkout-form {
    max-width: inherit;
  }
</style>