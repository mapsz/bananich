<template>
<div>
  
    <div class="container">
      <!-- Breadcrumbs -->
      <breadcrumbs />
      <div class="row content-page">

        <!-- Navbar -->
        <div class="col-lg-4">            
          <profile-navbar></profile-navbar>
        </div>

        <div class="col-lg-8">

          <div class="title-wrap">
            <h2 class="title-h2 title-page">Реферальная система</h2>
          </div>
        
          <div class="content">
            <p>
              Рассказывайте о Neolavka друзьям и знакомым и получайте бонусные баллы за каждого приведённого клиента!
            </p>
            
            <p>
              <b>Как это работает:</b>   <br>
              <ul style="list-style-type: unset; margin-left: 40px;">
                <li>Свяжитесь с нами любым удобным вам способом и запросите персональный промокод на первую доставку.</li>
                <li>Этим промокодом делитесь с друзьями, применив его они получат скидку 300 рублей на первую покупку.</li>
                <li>За каждого приведённого нам клиента вы получите 100 рублей баллами в личном кабинете. Ими можно оплатить ваши заказы на Neolavka.</li>
              </ul>
            </p>

            <div class="mt-3">
            
              <div class="mb-2" v-if="coupon && coupon.code != undefined">
                Ваш промокод: <b>{{coupon.code}}</b>  
              </div>
              
              <div class="d-flex" style="align-items: center; font-size:12pt;">
                <div>                
                  <b>Ваш текущий баланс баллов : {{balance}}</b>  
                </div>             
                <div>
                  <span @click="showPopup=true" class="ml-2 info-icon info-icon-sm info-icon-success" style="color: black;cursor:pointer;"></span>
                </div>
              </div>

            </div>

          </div>
        </div>

      </div>
    </div>


  <!-- About no Container -->
  <x-popup :title="''" :active="showPopup" @close="showPopup=false" id="membership-coupon-info-modal">
    Для участия в реферальной программе запросите любым удобным вам способом ( в соц сетях, или по телефону) генерацию вашего личного промокода на первую бесплатную доставку, которым вы сможете делиться со своими друзьями. Мы привяжем его к вашему аккаунту, и за каждого приведенного вами клиента вы будете получать бонусные баллы, которыми можно будет оплачивать покупки на нашем сайте.
  </x-popup> 

</div>
</template>

<script>
export default {
data(){return{
  balance:0,
  coupon:null,
  showPopup:false,
}},
async mounted() {
  this.getBalance();
  this.getCoupon();
},
methods:{
  async getBalance(){
    let r = await ax.fetch('/referral/user/balance');

    if(r) this.balance = r;
  },
  async getCoupon(){
    let r = await ax.fetch('/coupon/referral');

    if(r) this.coupon = r;

  }
},
}
</script>

<style>

</style>