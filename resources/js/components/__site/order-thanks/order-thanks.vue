<template>
<juge-main>
  
  <main>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-8">
          <div class="thanks">
            <div class="thanks-title">Спасибо вам за заказ!</div>

            <template v-if="user">
              <div class="thanks-text">Статус доставке вы можете отслеживать в <a href="/profile">личном кабинете</a></div>

                
              <div v-if="user && isX" class="thanks-text">
                При оформлении заказа в течении двух недель с момента доставки сервисный сбор в интервалах за 300 рублей будет автоматически пересчитан на 200 рублей!
              </div>

              <a v-if="isX" href="/profile/shared/orders" class="btn-yellow btn-thick btn-thanks">Перейти в заказы</a>
              <a v-else href="/profile/orders" class="btn-yellow btn-thick btn-thanks">Перейти в заказы</a>
            </template>


            <div v-if="!user">
              <span v-if="isX">
                Чтобы  иметь возможность отслеживать статусы заказов в личном кабинете, рекомендуем вам <a href="/profile">зарегистрироваться</a> 
              </span>
              <span v-else>              
                Чтобы в дальнейшем получать 10% кешбэка с каждой покупки, а также иметь возможность отслеживать статусы заказов в личном кабинете, рекомендуем вам <a href="/profile">зарегистрироваться</a> 
              </span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>

</juge-main>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
data(){return{
  isX:isX,
}},
computed:{
  ...mapGetters({user:'user/get'}),
  mounted(){    
  },
},

}
</script>

<style>

</style>