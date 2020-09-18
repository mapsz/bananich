<template>
  <main>
    <div class="container">
      <!-- Breadcrumbs -->
      <breadcrumbs />
      <div class="row content-page">
        <!-- Navbar -->
        <div class="col-lg-4">            
          <profile-navbar></profile-navbar>
        </div>        
        <!-- Content -->
        <div class="col-lg-8">
          <div class="title-wrap title-page">
            <h2 class="title-h2">Бонусы</h2>
          </div>
          <div class="content">
            <div class="bonuse-block d-flex align-items-center justify-content-lg-start justify-content-center">
              <div class="bonuse-num">
                <span class="bonuse-num-now">{{lastBonus.quantity != undefined ? lastBonus.quantity : 0}}</span> /  <span class="bonuse-num-target">{{currentBonus}}</span>
                <div class="bonuse-num-text">сгорят через</div>
              </div>
              <div class="bonuse-progres">
                <img src="/image/demo-bonuse.png" alt="Demo">
                <div class="bonuse-progres-text">15 <span>дней</span></div>
              </div>
            </div>
            <ul class="bonuse-list">
              <li class="bonuse-item"  :class="showHistory ? 'active' : ''">
                <a @click.prevent="showHistory = !showHistory" class="bonuse-item-btn" href="#!">История</a>
                <div v-if="showHistory" class="story">

                  <div v-for='(bonus,i) in bonuses' :key='i' class="story-item">
                    <div class="d-md-flex justify-content-center">
                      <div class="story-date">{{moment(bonus.created_at).lang('ru').format('lll')}}</div>
                      <div class="story-track">
                        {{bonus.bonus_type_id == 1 ? 'Админ' : ''}}
                        <!-- TRK09845098 -->
                      </div>
                    </div>
                    <div class="story-bonuse">{{bonus.quantity}} Б</div>
                  </div>

                </div>
              </li>
              
              <!-- Rules -->
              <li  class="bonuse-item"  :class="showRules ? 'active' : ''">
                <a @click.prevent="showRules = !showRules" class="bonuse-item-btn" href="#!">Правила бонусной сиcтемы</a>        
                <div v-if="showRules" class="rule d-md-flex align-items-center">
                  <div class="rule-left">
                    <div class="rule-round">
                    <div class="rule-text">Получайте 10% кешбэк <span>с каждой покупки в бонусах</span></div>
                  </div>
                  </div>
                  <div class="rule-right">

                    <div class="rule-item color-s ml-100">
                      <div class="d-flex">
                        <div class="rule-item-img color-s"><img src="/image/bonuse/icon_bonus.svg" alt="bonus"></div>
                        <div class="rule-item-text">Бонусы появляются после доставки заказа и начисляются только на сумму, <b>оплаченную клиентом рублями</b></div>
                      </div>
                    </div>

                    <div class="rule-item color-m">
                      <div class="d-flex">
                        <div class="rule-item-img color-m"><img src="/image/bonuse/icon_money.svg" alt="money"></div>
                        <div class="rule-item-text"><div class="d-flex"><span class="box">Оплачивайте бонусами до 100% товаров со знаком<span class="d-flex d-md-none"><b>1 бонус = 1 рублю</b></span></span> <img src="/image/bonuse/icon_b.svg" alt=""></div></div>
                      </div>
                    </div>

                    <div class="rule-item color-l">
                      <div class="d-flex">
                        <div class="rule-item-img color-l"><img src="/image/bonuse/icon_fire.svg" alt="fire"></div>
                        <div class="rule-item-text">Бонусы сгорают после <b>2-х недель после начисления</b></div>
                      </div>
                    </div>

                    <div class="rule-item color-xl ml-100">
                      <div class="d-flex">
                        <div class="rule-item-img color-xl"><img src="/image/bonuse/icon_block.svg" alt="block"></div>
                        <div class="rule-item-text">Заморозить бонусы можно на <b>2 недели раз в пол года,</b> позвонив нашему оператору</div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <!-- Referals -->
              <li class="bonuse-item" :class="showReferal ? 'active' : ''">
                <a @click.prevent="showReferal = !showReferal" class="bonuse-item-btn" href="#!">Правила реферальной сиcтемы</a>
                <div v-if="showReferal" class="refer">
                  <div class="refer-img"><img src="/image/bonuse/reload.svg" alt="reload" style="margin: auto;"></div>
                  <div class="d-flex">
                  <div class="refer-left">
                    <img src="/image/bonuse/user.svg" alt="user" style="margin: auto;">
                    <div class="refer-name">Маша</div>
                    <ol>
                      <li><b>Зарегистрирована</b> на нашем сайте и совершает покупки</li>
                      <li><b>Рекомендует нас</b> своему другу Саше</li>
                      <li><b>Получает 10% кешбэк</b> в бонусах с первой покупки Саши</li>
                    </ol>
                  </div>
                  <div class="refer-right">
                    <img src="/image/bonuse/user.svg" alt="user" style="margin: auto;">
                    <div class="refer-name">Миша</div>
                    <ol>
                      <li><b>При регистрации</b> указывает номер телефона Маши</li>
                      <li><b>Получает 100 подарочных бонусов</b> при регистрации. Ими можно воспользоваться после получения первой доставки.</li>
                      <li><b>Получает 10% кешбэк</b> в бонусах с первой покупки</li>
                    </ol>
                  </div>
                </div>
                  <div class="refer-text">
                    <p>1 бонус = 1 рублю</p>
                    <p>Бонусы сгорают через 2 недели после начисления</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    

  </main>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    showHistory:false,
    showRules:false,
    showReferal:false,
    moment:moment,
  }},
  computed:{
    ...mapGetters({bonuses: 'bonus/get',}),
    currentBonus: function(){
      return (this.bonuses != undefined && this.bonuses[0] != undefined) ? this.bonuses[0].left : 0;
    },
    lastBonus: function(){
      if(this.bonuses[this.bonuses.length-1] == undefined) return false;
      return this.bonuses[this.bonuses.length-1];
    }
  },
}
</script>

<style scoped>
@media (max-width: 580px){
  .rule-item {
    height: inherit !important;
    padding: 10px  !important;
  }
}
</style>