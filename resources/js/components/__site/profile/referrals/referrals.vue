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
            
            <p style="font-size:12pt">
              <b>Ваш текущий баланс баллов : {{balance}}</b> 
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