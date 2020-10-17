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
            <div v-show="currentBonus" class="bonuse-block row">
              <!-- Current -->
              <div class="bonuse-num col-12 col-md-6" style="  margin-right: 0px; display: flex;flex-direction: column;">
                <span class="bonuse-num-now-a">
                  <span class="bonuse-num-now">
                    {{currentBonus}}
                  </span> 
                   
                  <span class="bonuse-num-target">                    
                    / {{soonDie.quantity != undefined ? soonDie.quantity : 0}}
                  </span>
                </span>
                <div class="bonuse-num-text">сгорят через</div>
              </div>
              <!-- Chart -->
              <div class="bonuse-progres col-12 col-md-6" style="height: auto;">
                <div>
                  <div class="bonus-chart-block my-3">
                    <div style="width:100%; position: relative; z-index: 2;">
                      <canvas id="bonus-chart"></canvas>
                    </div> 
                    <div class="bonuse-progres-text" style="z-index:1">{{soonDie.die_days}}<span>дней</span></div>   
                  </div>
                </div>
              </div>
            </div>

            <!-- History -->
            <ul class="bonuse-list">              
              <li v-if="bonuses.length > 0" class="bonuse-item"  :class="showHistory ? 'active' : ''">
                <a @click.prevent="showHistory = !showHistory" class="bonuse-item-btn" href="#!">История</a>
                <div v-if="showHistory" class="story">

                  <div v-for='(bonus,i) in bonuses' :key='i' class="story-item">
                    <div class="d-md-flex justify-content-center">
                      <!-- Date -->
                      <div class="story-date">{{moment(bonus.created_at).lang('ru').format('lll')}}</div>
                      <!-- Type -->
                      <div class="story-track" style="margin-right: 10px;">
                        {{bonus.bonus_type_id == 1 ? 'Админ' : ''}}
                        {{bonus.bonus_type_id == 2 ? 'Покупка' : ''}}
                        {{bonus.bonus_type_id == 3 ? 'Сгорание' : ''}}
                        {{bonus.bonus_type_id == 4 ? 'Резервация' : ''}}
                      </div>
                      <!-- comment -->
                      <div v-if="bonus.comment" class="story-comment" style="font-weight: 300;">
                        {{bonus.comment.comment}}
                      </div>
                    </div>
                    <div class="story-bonuse">
                      <span v-if="bonus.add_bonus">+{{bonus.quantity}}</span>
                      <span v-else>-{{bonus.quantity}}</span>  
                      Б
                    </div>
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
                      <li><b>Рекомендует нас</b> своему другу Мише</li>
                      <li><b>Получает 10% кешбэк</b> в бонусах с первой покупки Мише</li>
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
  watch: {
    bonuses: function(){
      if(!this.bonuses.length > 0){
        this.showRules = true;        
      } 
    },
    currentBonus:function(){
      if(this.currentBonus > 0) this.setCharts();
    }
  },
  computed:{
    ...mapGetters({bonuses: 'bonus/get',}),
    currentBonus: function(){
      return (this.bonuses != undefined && this.bonuses[0] != undefined) ? this.bonuses[0].left : 0;
    },
    soonDie: function(){
      if(this.bonuses[0] == undefined) return false;

      //Get bonus adds
      let bonusAdds = [];
      $.each(this.bonuses, ( k, v ) => {
        if(v.add_bonus) bonusAdds.push(v);
      });

      if(bonusAdds[0] == undefined) return false;

      //Soon die
      let soonBonus = bonusAdds[0];
      $.each(bonusAdds, ( k, v ) => {
        if(moment(v.add_bonus.die).unix() - moment(soonBonus.add_bonus.die).unix()  < 0){
          soonBonus = v;
        }
      });

      console.log(soonBonus);

      let bonus = soonBonus;
      bonus.die_days = moment(bonus.add_bonus.die).diff(moment(),'d');

      return bonus;
    }
  },
  mounted(){
    //
  },
  methods:{
    setCharts(){
      var ctx = document.getElementById('bonus-chart');
      var myChart = new Chart(ctx, {
          type: 'doughnut',
            data: {
              labels: [
                'Активные',
                'Скоро сгорят',
              ],
              datasets: [{
                borderWidth:3,
                data: [this.currentBonus, this.soonDie.quantity],
                label: 'БЖУ',
                backgroundColor: [
                  '#fbe214',
                  '#dcdcdc',
                ],
                hoverOffset: 4
              }]
            },
          options: {
            cutoutPercentage:75,     
            aspectRatio:1,  
            legend: {display: false}, //Hide labels
            tooltips: {enabled: false},hover: {mode: null}, //hide tooltips
          }
      });   
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

  @media (max-width: 767px){   
    .bonuse-num{
      align-items: center;
    } 
  }

  @media (min-width: 768px){
    .bonuse-num-now-a{
      align-self: flex-end;
    }      
  }

  .bonus-chart-block{
    width: 180px;    
    height: 180px;
    display: flex;
    position: relative;
    margin: auto;
  }
</style>