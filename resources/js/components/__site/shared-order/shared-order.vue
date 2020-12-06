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
          <!-- <div class="col-4">
            <h4>Оплата</h4>
            <div>К оплате: 600 </div>
            <div>Оплачено: 0</div>
          </div> -->
          <!-- Status -->
          <div v-if="sOrder.status != undefined" class="col-4">
            <h4>Статус</h4>
            <div>{{sOrder.status.name}}</div>
          </div>
          <!-- Pay -->
          <div v-if="sOrder.status != undefined" class="col-4">
            <h4>Оплата до</h4>
            <div>{{payTill}}</div>
          </div>
          <!-- Close -->
          <div v-if="sOrder.status != undefined" class="col-4">
            <h4>Закрытие</h4>
            <div>{{closeAt}}</div>
          </div>
        </div>

        <div v-if="sOrder" class="row mt-3">
          <!-- Details -->
          <div class="col-4">
            <h4>Детали заказа</h4>

            <checkout-contact class="checkout-div " v-model="data.contacts" />

          </div>
          
          <!-- Users -->
          <div class="col-4">
            <h4>Участники</h4>
            <div>
              <div v-for="(v, index) in users" :key="index">
                <span :class="v.id == user.id  ? 'text-info' : ''">
                  <span v-if="v.id == sOrder.owner_id">👑</span> {{v.name}} {{v.email}}
                </span> 
                <div v-if="weights">
                  Вес: {{weights[v.id]}}
                </div>                  
                <button v-if="userIn && (sOrder.pays.findIndex(x => x.user_id == v.id) == -1)" @click="pay(v.id)" class="btn btn-info">Оплатить</button>              
                <hr>
              </div>
            </div>

            <button v-if="!userIn" @click="join()" class="btn btn-primary">Присоединиться</button>
          </div>          
          
          <!-- Weight -->
          <div class="col-4">
            <h4>Вес</h4>
            <div v-if="weights">
              <div>Доступно: 25кг</div>
              <div>Использовано: {{weights.overall}}кг</div>
              <!-- <div>не использовано: {{25 - weights.overall}}кг</div> -->
            </div>
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
  data:{},
  shareDescription:"Очень крутой текст!",
  weights:false,
}},
computed:{
  ...mapGetters({
    sOrders:'sharedOrder/get',
    user:'user/get',
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
  userIn(){
    let r = false;
    if(!this.users || this.users.length < 1) return r;
    
    this.users.forEach(user => {
      if(user.id == this.user.id) r = true;
    });

    return r;

  },
  payTill(){
    let r = false;
    if(!this.sOrder || this.sOrder.delivery_date == undefined) return false;
    
    return moment(this.sOrder.delivery_date).subtract(1, 'd').format('DD.MM.YYYY') + " 18:00";

  },
  closeAt(){
    let r = false;
    if(!this.sOrder || this.sOrder.delivery_date == undefined) return false;
    
    return moment(this.sOrder.delivery_date).subtract(1, 'd').format('DD.MM.YYYY') + " 21:00";

  }
},
async mounted() {
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
  async pay(userId){
    let r = await ax.fetch('/shared/order/pay',{'order_id':this.sOrder.id, 'user_id':userId},'put');
    if(r){
      window.location.reload();
    }

  },
  async getWeights(){
    let r = await ax.fetch('/shared/order/weights',{id:this.sOrder.id});
    if(r){
      this.weights = r;
    }

  }
},
}
</script>

<style>

</style>