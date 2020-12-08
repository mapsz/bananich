<template>
  <div>
    <site-header/>
    
      <div class="container my-3">

        <h1 class="m-3">Формирование коллективной закупки</h1>

        <!-- Loading -->
        <div v-if="!sOrder" class="d-flex m-5" style="justify-content: center;">
          <span style="font-size: 48pt;">🍌🍌</span>
        </div>
        
        <!-- Invite -->
        <div v-if="shareLink" class="row mt-3">
          <div class="col-12">
            <h4>Пригласить</h4>

            
            <div>
              <span class="text-primary">{{shareLink}}</span>
            </div>
            
            <div>              
              <telegram-button
                :shareUrl="shareLink"
                :description="shareDescription"
              />
              <whatsapp-button
                :shareUrl="shareLink"
                :description="shareDescription"
              />
              <vkontakte-button
                :shareUrl="shareLink"
                :description="shareDescription"
              />
              <div>
                https://github.com/Alexandrshy/vue-share-buttons
              </div>
            </div>
          </div>
        </div>

        <div v-if="sOrder" class="row mt-3">
          <!-- Pay -->
          <div class="col-4">
            <h4>Оплата</h4>
            <div>К оплате: {{sOrder.full_price}} </div>
            <div>Оплачено: {{sOrder.payed}}</div>
          </div>
          <!-- Info -->
          <div v-if="sOrder.status != undefined" class="col-4">
            <h5>Статус</h5>
            <div>{{sOrder.status.name}}</div>
            <h5>Адрес</h5>
            <div>{{sOrder.address.street}} {{sOrder.address.appart}}</div>
            <h5>Доставка</h5>
            <div>{{moment(sOrder.delivery_date).locale("ru").format('LL')}}</div>
            <div>{{sOrder.delivery_time_from}} - {{sOrder.delivery_time_to}}</div>
          </div>

          <div class="col-4">
            <!-- Test time -->
            <div v-if="sOrder.status != undefined" >
              <h5>Test time</h5>
              <div><b>now:  </b>{{moment().locale("ru").format('LLLL')}}</div>
              <div><b>fake: </b>{{moment(sOrder.test_time).locale("ru").format('LLLL')}}</div>
              <div class="d-flex">
                <label for="t-h">Hours: </label><input v-model="test.hours"  type="number" name="hour" id="t-h" style="width:60px">
                <label for="t-m" class="ml-3">Minutes: </label><input v-model="test.minutes"  type="number" name="minute" id="t-m"  style="width:60px">
                <button @click="updateTestTime()" class="btn btn-primary ml-3">update</button>
              </div>
            </div>
            <!-- Pay -->
            <div v-if="sOrder.status != undefined" >
              <h5>Оплата до</h5>
              <div>{{moment(sOrder.pay_close).locale("ru").format('LLLL')}}</div>
            </div>
            <!-- Close -->
            <div v-if="sOrder.status != undefined">
              <h5>Закрытие</h5>
              <div>{{moment(sOrder.order_close).locale("ru").format('LLLL')}}</div>
            </div>
          </div>
        </div>

        <div v-if="sOrder" class="row mt-3">

          <!-- Weight -->
          <div class="col-4">
            <h4>Вес</h4>
            <div v-if="weights">
              <div><b>Общий</b></div>
              <div>Доступно: {{sOrder.full_weight}}кг</div>
              <div>Использовано: {{weights.overall}}кг</div>
              <div><b>Мой</b></div>
              <div>Доступно: {{sOrder.user_weight}}кг</div>
              <div>Использовано: {{weights[user.id]}}кг</div>
              <!-- <div>не использовано: {{25 - weights.overall}}кг</div> -->
            </div>
          </div>

          <!-- Details -->
          <div class="col-4">
            <h4>Детали заказа</h4>
            <checkout-contact class="checkout-div " v-model="data.contacts" />
          </div>
          
          <!-- Users -->
          <div class="col-4">
            <div v-if="sOrder && userIn">
              <h4>Участники</h4>
              <hr>
              <template v-if="slots">
                <div v-for="(n, i) in sOrder.member_count" :key="i">
                  <!-- Member -->
                  <div>
                    <div v-if="slots[n].user != undefined">
                      <span :class="slots[n].user.id == user.id  ? 'text-info' : ''">
                        <span v-if="slots[n].user.id == sOrder.owner_id">👑</span> {{slots[n].user.name}} {{slots[n].user.email}}
                      </span>
                      <div v-if="weights">
                        Вес: {{weights[slots[n].user.id]}}
                      </div>  
                    </div>
                    <div v-else>
                      Invite!
                    </div>
                  </div>

                  <!-- Pay -->
                  <div>
                    <div v-if="slots[n].pay == undefined">
                      <button 
                        @click="pay(user.id, n)" 
                        class="btn btn-info"
                      >
                        Оплатить {{sOrder.user_price}}p
                      </button>
                    </div>
                    <div v-else>
                      <span class="text-success">Оплачено</span>
                      <span>
                        {{slots[n].pay.user.name}} {{slots[n].pay.user.email}}
                      </span>
                    </div>
                  </div>

                  <hr>
                </div>
              </template>
            </div>
            <button v-if="!userIn" @click="join()" class="btn btn-primary">Присоединиться</button>
          </div>          

        </div>

      </div>

    <site-footer/>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  moment:moment,
  test:{},
  data:{},
  shareDescription:"Очень крутой текст!",
  weights:false,
}},
computed:{
  ...mapGetters({
    sOrders:    'sharedOrder/get',
    user:       'user/get',
  }),
  shareLink(){
    if(!this.link) return false;
    return window.location.origin+'/shared/order/' + this.link;
  },
  link (){
    if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
    return this.$route.params.order_link;
  },
  sOrder (){
    if(this.sOrders == undefined || this.sOrders.length < 1) return false;
    return this.sOrders[0];
  },
  users(){
    if(!this.sOrder || this.sOrder.users == undefined || this.sOrder.users.length < 1) return [];
    return this.sOrder.users;
  },
  slots(){
    if(!this.sOrder || this.sOrder.member_count == undefined || this.sOrder.member_count < 1) return [];
    if(this.sOrder.users == undefined) return [];

    let slots = []
    for (let i = 1; i <= this.sOrder.member_count; i++) {
      let user = this.sOrder.users.find(x => x.slot == i);
      let pay = this.sOrder.pays.find(x => x.slot == i);
      if(pay != undefined){
        pay.user = this.users.find(x => x.id == pay.user_id);
      }

      slots[i] = {
        user:user,
        pay:pay
      };      
    }

    return slots;

  },
  userIn(){
    let r = false;
    if(!this.users || this.users.length < 1) return r;
    
    this.users.forEach(user => {
      if(user.id == this.user.id) r = true;
    });

    return r;

  }
},
async mounted(){
  //Open shared order
  if(!this.link){
    this.open();
  }
  //Get shared order
  else{
    console.log('get');
    await this.filter({'link':this.link});
    await this.get();
  }

  if(this.sOrder){
    this.getWeights();
  }
},
methods:{
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
  }),   
  async open(){
    let r = await ax.fetch('/shared/order/open',{},'put');
    if(r){
      window.location.href = '/shared/order/'+r.link;
    }
  },
  async join(){
    let r = await ax.fetch('/shared/order/join',{'link':this.link},'post');
    if(r){
      window.location.reload();
    }
  },
  async pay(userId,slot){
    let r = await ax.fetch('/shared/order/pay',{'order_id':this.sOrder.id, 'user_id':userId, 'slot':slot},'put');
    this.get();
  },
  async getWeights(){
    let r = await ax.fetch('/shared/order/weights',{id:this.sOrder.id});
    if(r){
      this.weights = r;
    }
  },
  async updateTestTime(){
    let r = await ax.fetch('/shared/order/test/time',{'id':this.sOrder.id,'test':this.test},'post');
    this.get();
  }
},
}
</script>

<style>

</style>