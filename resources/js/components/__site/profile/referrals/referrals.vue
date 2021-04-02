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
              Как это работает: <br>
              Свяжитесь с нами любым удобным вам способом и запросите персональный промокод на первую доставку.  <br>
              Этим промокодом делитесь с друзьями, применив его они получат скидку 300 рублей на первую покупку.  <br>
              За каждого приведённого нам клиента вы получите 100 рублей баллами в личном кабинете. Ими можно оплатить ваши заказы на Neolavka.  <br>
            </p>
            
            <p>
              Ваш текущий баланс баллов : {{balance}}
            </p>

          </div>
        </div>

      </div>
    </div>
</div>
</template>

<script>
export default {
data(){return{
  balance:0,
}},
async mounted() {
  this.getBalance();
},
methods:{
  async getBalance(){
    let r = await ax.fetch('/referral/user/balance');

    if(r) this.balance = r;
  }
},
}
</script>

<style>

</style>