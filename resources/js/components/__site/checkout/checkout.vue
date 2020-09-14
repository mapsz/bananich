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

        <div class="row content-page">

          <div class="col-lg-8">
            <div class="content">
              <checkout-contact v-model="data.contacts" />

              <checkout-toother v-model="data.toOther" />

              <checkout-address v-model="data.address"/>

              <checkout-date-time v-model="data.dateTime"/>

              <div class="row">
                <checkout-container v-model="data.container"/>
                <checkout-paymethod v-model="data.paymethod"/>
              </div>
              
              <checkout-confirm v-model="data.confirm"/>

              <checkout-comment v-model="data.comment"/>

            </div>
          </div>
          <div class="col-lg-4">
            <!-- Sitebar -->
              <div class="cart-sitebar">
                <buy-info />
                <!-- Errors -->
                <ul>
                  <template v-for='error in errors'>
                    <li v-for='err in error' :key="err" style="color:tomato">
                      {{err}}
                    </li>
                  </template>
                </ul>            
                <button @click="doOrder()" class="btn-yellow btn-thick">Оформить заказ</button>
              </div>
            <!-- Sitebar -->
          </div>
        </div>
      </div>
    </main>

    <site-footer/>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  data(){return{
    data:{},
    errors:[],
  }},
  computed:{
    ...mapGetters({cart:'cart/getCart'}),
  },
  methods:{
    async doOrder(){
      //Refresh errors
      if(ax.lastResponse.data != undefined && ax.lastResponse.data.errors != undefined) ax.lastResponse.data.errors = [];
      this.errors = [];

      //Setup data
      let data  = this.data;

      //Put      
      let r = await ax.fetch('/order/put', {data,'cartId':this.cart.id}, 'put');

      //Catch errors
      if(!r){      
        if(ax.lastResponse.status == 422){
          this.errors = ax.lastResponse.data.errors;
          return;
        }
      }

      if(r > 0)
        location.href ='/order-thanks';

      // //Check signin
      // await this.getUser();
      // if(this.user.id != undefined) location.reload();
      // }
    },
  }
}
</script>

<style>

</style>