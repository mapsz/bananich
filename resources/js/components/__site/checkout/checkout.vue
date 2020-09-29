<template>
  <div>
    <site-header/>

    <main class="cart-page">
      <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item"><a href="#">Корзина</a></li>
            <li class="breadcrumb-item active">Оформление заказа</li>
          </ol>
        </nav>

          <div class="d-flex mt-4 mt-sm-0">
            <a href="#!" class="arrow-back"><img src="image/arrow.svg" alt="arrow"></a>
            <h1 class="title-page">Оформление заказа</h1>
          </div>

        <div class="row content-page checkout-data">

          <div class="col-lg-7">
            <div class="content">
              <checkout-contact class="checkout-div " v-model="data.contacts" />

              <checkout-login class="checkout-div" />

              <checkout-toother class="checkout-div" v-model="data.toOther" />

              <checkout-address class="checkout-div" v-model="data.address"/>

              <checkout-date-time class="checkout-div" v-model="data.dateTime"/>

              <div class="row checkout-div">
                <checkout-container v-model="data.container"/>
                <checkout-paymethod v-model="data.paymethod"/>
              </div>
              
              <checkout-confirm class="checkout-div" v-model="data.confirm"/>

              <checkout-comment class="checkout-div" v-model="data.comment"/>

            </div>
          </div>
          <checkout-checkout :errors="errors" @do-order="doOrder()"/>
        </div>
      </div>
    </main>

    <site-footer/>
  </div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
  data(){return{
    data:{},
    errors:[],
  }},
  computed:{
    ...mapGetters({cart:'cart/getCart',checkout:'checkout/get'}),
  },
  mounted(){
    fbq('track', 'InitiateCheckout');
  },
  methods:{    
    ...mapActions({'clean':'checkout/clean'}),
    async doOrder(){
      //Refresh errors
      if(ax.lastResponse.data != undefined && ax.lastResponse.data.errors != undefined) ax.lastResponse.data.errors = [];
      this.errors = [];

      //Put      
      let r = await ax.fetch('/order/put', {data:this.checkout,'cartId':this.cart.id}, 'put');

      //Catch errors
      if(!r){      
        if(ax.lastResponse.status == 422){
          this.errors = ax.lastResponse.data.errors;
          return;
        }
      }

      if(r > 0){
        // Pixel        
        if(window.location.hostname != "bananich.loc") fbq('track', 'Purchase', {value: this.cart.final_summ, currency: 'RUB'});        
        this.clean();
        ax.fetch('/order/update/available', {id:r});
        location.href ='/order-thanks';
      }
        

      // //Check signin
      // await this.getUser();
      // if(this.user.id != undefined) location.reload();
      // }
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
</style>