<template>
<div>
  <site-header/>
  
  <main>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-8">
          <div class="thanks">
            <div class="thanks-title">Спасибо вам за заказ!</div>
            <div v-if="user" class="thanks-text">Статус о доставке вы можете отслеживать в <a href="/profile">личном кабинете</a></div>
            <a v-if="user" href="/profile/orders" class="btn-yellow btn-thick btn-thanks">Перейти в заказы</a>
            <div v-if="!user">Чтобы в дальнейшем получать 10% кешбэка с каждой покупки, а также иметь возможность отслеживать статусы заказов в личном кабинете, рекомендуем вам <a href="/profile">зарегистрироваться</a> </div>
          </div>
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
computed:{
  ...mapGetters({user:'user/get'}),
  mounted(){    
    fbq('track', 'Purchase', {value: this.cart.final_summ, currency: 'RUB'});
  },
},

}
</script>

<style>

</style>