<template>
  <div>
    <juge-main>
    
      <div class="container my-3">

        <!-- Congratz -->
        <div v-if="isAdmin" class="row mb-3">
          <div class="col-12">
            <div class="congratz">
              Поздравляем, ваша совместная закупка открыта!
            </div>
          </div>
        </div>

        <!-- top text -->
        <div v-if="isAdmin" class="row mb-4">
          <div class="col-12">
            <div class="top-text">
              Теперь можно пригласить в нее соседей или друзей!
            </div>
          </div>
        </div>

        <!-- Invite -->
        <div v-if="isAdmin" class="row">
          <!-- Button -->
          <div class="col-12 col-lg-6 p-0 mb-4 mt-lg-3 d-flex justify-content-center justify-content-lg-start ">
            <button class="button x-btn">
              Пригласить в закупку соседей
            </button>
          </div>
          <!-- Soc. buttons -->
          <div class="col-12 col-lg-6">
            Поделиться:
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
            </div>
          </div>
        </div>

        <hr class="my-5">

        <!-- Announce/Sould do -->
        <div v-if="isAdmin" class="row" style="margin-bottom:100px">
          <!-- Announce -->
          <div class="col-12 col-lg-6">
            <div class="announce-block">
              <div class="mb-3"><b>Вы можете менять дату, время и адрес закупки только до момента присоединения к ней другого участника.</b></div>  
              <div>После этого вы сможете вносить изменения только в свою корзину до 21.00 дня накануне доставки.</div>  
            </div>
          </div>
          <!-- Sould do -->
          <div class="col-12 col-lg-6 d-flex justify-content-center  justify-content-lg-start" style="display: flex !important;align-items: flex-end;">
            <button @click="goToGallery()" class="button x-btn">
              Начать оформлять заказ
            </button>
          </div>
        </div>


        <!-- Close -->
        <div class="row">
          <div class="col-12">
            <!-- Close -->
            <div v-if="sOrder.status != undefined">
              <h5>Закрытие</h5>
              <div>{{moment(sOrder.order_close).locale("ru").format('LLLL')}}</div>
            </div>
            <!-- Test time -->
            <div v-if="sOrder.status != undefined" class="border p-2" style="background-color: #fb00ff40;">
              <h5>Test time</h5>
              <div><b>now:  </b>{{moment().locale("ru").format('LLLL')}}</div>
              <div><b>fake: </b>{{moment(sOrder.test_time).locale("ru").format('LLLL')}}</div>
              <div class="d-flex">
                <label for="t-h">Hours: </label><input v-model="test.hours"  type="number" name="hour" id="t-h" style="width:60px">
                <label for="t-m" class="ml-3">Minutes: </label><input v-model="test.minutes"  type="number" name="minute" id="t-m"  style="width:60px">
                <button @click="updateTestTime()" class="btn btn-primary ml-3">add</button>
              </div>
            </div>
          </div>
        </div>        

        <!-- Members -->
        <div v-if="owner && slots" class="row mb-4">
          <!-- Owner -->
          <div class="col-12 col-lg-6 mb-4" :class="sOrder.member_count == 1 ? 'offset-lg-6' : ''">
            <div class="user-group-header mb-3">Организатор</div>
            <shared-order-member :mSlot="1" :user="owner" />
          </div>
          <!-- Other Members -->
          <div  v-if="sOrder.member_count > 1" class="col-12 col-lg-6">
            <div class="user-group-header mb-3">Участники закупки</div>
            <!-- Members List -->
            <div v-for="(n, i) in sOrder.member_count" :key="i">
              <shared-order-member 
                v-if="
                  slots[n] == undefined || 
                  slots[n].user == undefined || 
                  slots[n].user.id == undefined || 
                  slots[n].user.id != owner.id
                "                   
                :mSlot="n" :user="slots[n].user != undefined ? slots[n].user : {}"
              />
              <hr v-if="n < sOrder.member_count && n > 1" class="my-4">              
            </div>
            <!-- Join -->
            <div class="d-flex justify-content-center mt-3">
              <button v-if="!userIn && !isFull" @click="join()" class="x-btn" style="height:50px">Стать участником</button>
            </div>            
          </div>
        </div>

        <hr class="my-4">

        
        <div class="row" v-if="sOrder">
          <div class="col-12 col-lg-6 offset-lg-6">

            <!-- Price -->
            <div>
              <div class="label">
                Стоимость вашего участия
              </div>
              <div class="value">
                {{sOrder.user_price}}р
              </div> 
            </div>

            <!-- Address -->
            <div>
              <hr class="my-30">
              <div class="label">
                Адрес доставки
              </div>
              <div class="value">
                {{sOrder.address.street}} {{sOrder.address.appart}}
              </div> 
            </div>

            <!-- Date/Time -->
            <div>
              <hr class="my-30">
              <div>
                <span class="label">дата и время доставки</span>
                <button v-if="isAdmin && editable" @click="goToEdit()" class="edit float-right">изменить</button>
              </div>
              <div class="value">
                <div>{{moment(sOrder.delivery_date).locale("ru").format('LL')}}</div>
                <div>
                  {{sOrder.delivery_time_from.replace(':00:00', ':00')}} - 
                  {{sOrder.delivery_time_to.replace(':00:00', ':00')}}
                </div>
              </div> 
            </div>

            <!-- Weight -->
            <div>
              <hr class="my-30">
              <div>
                <span class="label">Макс. бесплатный вес - </span>
                <span class="value">{{sOrder.user_weight}}кг</span> 
                <span class="ml-3 info-icon"></span>
              </div>
              <div v-if="userIn">
                <span class="label">вес вашей корзины - </span>
                <span class="value">{{weights[user.id]}}кг</span>                
                <button v-if="isAdmin && editable" @click="goToEdit()" class="edit float-right">изменить</button>
              </div>
            </div>          

            <!-- Comment -->
            <div>
              <hr class="my-30">
              <div>
                <span class="label">КОММЕНТАРИЙ К ЗАКУПКЕ</span>
                <button v-if="isAdmin && editable" @click="goToEdit()" class="edit float-right">изменить</button>
              </div>
              <div>
                <span class="value">{{(sOrder.comment && sOrder.comment.body != undefined) ? sOrder.comment.body : ''}}</span>
              </div>
            </div>

            <!-- Actions -->
            <div class="mb-5">
              <hr class="my-30">
              <!-- Edit order -->
              <div class="mb-3">
                <button v-if="isAdmin && editable" @click="goToEdit()" class="action">
                  Редактировать 
                  <span style="font-size:16px;color: rgba(0, 0, 0, 0.6);">
                    (Вы можете вносить изменения в дату и время закупки пока к ней никто еще не присоединился)
                  </span>
                </button>
              </div>
              <!-- Cancel order -->
              <div v-if="isAdmin && sOrder.status.id > 0">
                <button @click="sOrderCancel()" class="action">Отменить закупку</button>
              </div>     
            </div>

            <!-- Big Action -->
            <div>
              <button v-if="weights[user.id] <= 0" @click="goToGallery()" class="x-btn">
                Начать оформлять заказ
              </button>

              <button v-if="weights[user.id] > 0" @click="goToCheckout()" class="x-btn x-btn-red">
                Завершить оформление заказа
              </button>
            </div>

          </div>
        </div>
        

        <div v-if="0">

          <h1 class="m-3">Формирование коллективной закупки</h1>

          <!-- Loading -->
          <div v-if="!sOrder" class="d-flex m-5" style="justify-content: center;">
            <span style="font-size: 48pt;">🍌🍌</span>
          </div>
          
          <div v-if="sOrder" class="row">
            <!-- Pay -->
            <!-- <div class="col-4">
              <h4>Оплата</h4>
              <div>К оплате: {{sOrder.full_price}} </div>
              <div>Оплачено: {{sOrder.payed}}</div>
            </div> -->
            
            <!-- Invite -->
            <div v-if="shareLink" class="col-4 border">
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

            <!-- Info -->
            <div v-if="sOrder.status != undefined" class="col-4 border">
              <h4>Данные заказа</h4>
              <!-- Status -->
              <div>
                <h5>Статус</h5>
                <div>
                  <span :class="sOrder.status.id == 0 ? 'text-danger' : ''">{{sOrder.status.name}}</span>              
                </div>
              </div>
              <!-- Address -->
              <div>
                <h5>Адрес</h5>
                <div>{{sOrder.address.street}} {{sOrder.address.appart}}</div>
              </div>
              <!-- Time Date -->
              <div>
                <h5>Доставка</h5>
                <div>{{moment(sOrder.delivery_date).locale("ru").format('LL')}}</div>
                <div>{{sOrder.delivery_time_from}} - {{sOrder.delivery_time_to}}</div>
              </div>
            </div>

            <!-- Timers -->
            <div class="col-4 border">
              <!-- Pay -->
              <!-- <div v-if="sOrder.status != undefined" >
                <h5>Оплата до</h5>
                <div>{{moment(sOrder.pay_close).locale("ru").format('LLLL')}}</div>
              </div> -->
              <!-- Close -->
              <div v-if="sOrder.status != undefined">
                <h5>Закрытие</h5>
                <div>{{moment(sOrder.order_close).locale("ru").format('LLLL')}}</div>
              </div>
              <!-- Test time -->
              <div v-if="sOrder.status != undefined" class="border p-2" style="background-color: #fb00ff40;">
                <h5>Test time</h5>
                <div><b>now:  </b>{{moment().locale("ru").format('LLLL')}}</div>
                <div><b>fake: </b>{{moment(sOrder.test_time).locale("ru").format('LLLL')}}</div>
                <div class="d-flex">
                  <label for="t-h">Hours: </label><input v-model="test.hours"  type="number" name="hour" id="t-h" style="width:60px">
                  <label for="t-m" class="ml-3">Minutes: </label><input v-model="test.minutes"  type="number" name="minute" id="t-m"  style="width:60px">
                  <button @click="updateTestTime()" class="btn btn-primary ml-3">add</button>
                </div>
              </div>
            </div>

            <!-- Weight -->
            <div class="col-4 border">
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
            <div class="col-4 border">
              <h4>Личнные данные</h4>
              <checkout-contact class="checkout-div " v-model="data.contacts" />
            </div>
            
            <!-- Users -->
            <div class="col-4 border">
              <div v-if="sOrder && userIn">
                <h4>Участники</h4>

                <hr>

                <!-- Members -->
                <template v-if="slots">
                  <div v-for="(n, i) in sOrder.member_count" :key="i">
                    <!-- Member -->
                    <div>
                      <div v-if="slots[n].user != undefined">
                        <!-- Name -->
                        <span :class="slots[n].user.id == user.id  ? 'text-info' : ''">
                          <span v-if="slots[n].user.id == sOrder.owner_id">👑</span> {{slots[n].user.name}} {{slots[n].user.email}}
                        </span>
                        <!-- kick -->
                        <span v-if="isAdmin">
                          <button v-if="slots[n].user.id != user.id" @click="kick(slots[n].user.id)" class="btn btn-danger btn-sm">
                            выкинуть 🥾
                          </button>
                        </span>
                        <!-- Weight -->
                        <div v-if="weights">
                          Вес: {{weights[slots[n].user.id]}}
                        </div>  
                      </div>
                      <!-- Invite -->
                      <div v-else>
                        <i style="font-style: italic;">Invite!</i> 
                      </div>
                    </div>

                    <!-- Pay -->
                    <div>
                      <!-- <div v-if="slots[n].pay == undefined">
                        <button 
                          @click="pay(user.id, n)" 
                          class="btn btn-info"
                        >
                          Оплатить {{sOrder.user_price}}p
                        </button>
                      </div> -->
                      <!-- Pay -->
                      <!-- <div v-else>
                        <span class="text-success">Оплачено</span>
                        <span>
                          {{slots[n].pay.user.name}} {{slots[n].pay.user.email}}
                        </span>
                      </div> -->
                    </div>

                    <hr>
                  </div>
                </template>

                <!-- Change member count -->
                <div v-if="isAdmin" class="form-group">
                  <label for="member-count">Количество участников: <b>{{changeMemberCount}}</b></label>
                  <input v-model="changeMemberCount" type="range" class="form-control" id="member-count" min="1" max="5">
                  <button @click="post({'member_count':changeMemberCount})" class="btn btn-sm btn-success">Сохранить</button>
                </div>

              </div>
              <button v-if="!userIn" @click="join()" class="btn btn-primary">Присоединиться</button>
            </div>   

            <!-- Cancel -->
            <div v-if="isAdmin && sOrder.status.id > 0" class="col-4 border">
              <button @click="sOrderCancel()" class="btn btn-danger m-3">Отменить закупку</button>
            </div>       

          </div>

        </div>



      </div>
    
    <login-modal :p-show="showLogin" :p-show-type="'signup'" @close="showLogin=false" />

    </juge-main>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  moment:moment,
  changeMemberCount:1,
  test:{},
  data:{},
  shareDescription:"Очень крутой текст!",
  weights:false,
  showLogin:false,
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
  link(){
    if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
    return this.$route.params.order_link;
  },
  sOrder(){
    if(this.sOrders == undefined || this.sOrders.length < 1) return false;
    return this.sOrders[0];
  },
  users(){
    if(!this.sOrder || this.sOrder.users == undefined || this.sOrder.users.length < 1) return [];
    return this.sOrder.users;
  },
  owner(){
    if(this.users.length < 1) return false;
    let user = this.users.find(x => x.id == this.sOrder.owner_id);
    if(user == -1) return false;
    return user;
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

  },
  isAdmin(){
    if(this.user == undefined && !this.user) return false;
    if(!this.sOrder || this.sOrder.owner_id == undefined || this.sOrder.owner_id < 1) return false;
    if(this.user.id == this.sOrder.owner_id) return true;
    return false;
  },
  editable(){
    if(!this.sOrder || this.sOrder.editable == undefined) return false;

    return this.sOrder.editable
  },
  isFull(){
    if(!this.sOrder || this.sOrder.member_count == undefined || this.sOrder.users == undefined) return true;
    if(this.sOrder.users.length < 1) return true;
    if(this.sOrder.member_count > this.sOrder.users.length) return false;

    return true;
  }

},
watch:{
  sOrder: function (val, oldVal) {
    if(!this.sOrder || this.sOrder.member_count == undefined) return;
    this.changeMemberCount = this.sOrder.member_count;
    return;
  },
},
async mounted(){  
  //Open shared order
  if(!this.link){
    this.open();
  }
  //Get shared order
  else{
    await this.filter({'link':this.link});
    await this.get();
  }

  if(this.sOrder){
    await this.update();
    this.getWeights();
  }  


},
methods:{
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
    'update':'sharedOrder/update',
  }),
  goToEdit(){
    if(!this.link) return;
    location.href = '/shared/order/edit/' +this.link;
  },
  async open(){
    let r = await ax.fetch('/shared/order/open',{},'put');
    if(r){
      window.location.href = '/shared/order/'+r.link;
    }
  },
  async post(data){
    data.id = this.sOrder.id;
    let r = await ax.fetch('/shared/order',data,'post');
    if(r){this.get();}
  },
  async sOrderCancel(){
    let r = await ax.fetch('/shared/order',{id:this.sOrder.id},'delete');
    if(r){
      // this.get();
      window.location.href = "/";
    }
  },
  async join(){
    if(!this.user){
      this.showLogin = true;
      return;
    }


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
  async kick(userId){
    let r = await ax.fetch('/shared/order/kick',{'sOrderId':this.sOrder.id,'userId':userId},'delete');
    this.get();
  },
  async goToGallery(){
    location.href = '/';
  },
  async goToCheckout(){
    location.href = '/shared/order/checkout/'+this.link;
  },

  //TEST
  async updateTestTime(){
    let r = await ax.fetch('/shared/order/test/time',{'id':this.sOrder.id,'test':this.test},'post');
    this.get();
  },
},
}
</script>

<style scoped>
  .congratz{
    font-size: 22px;
    font-style: normal;
    font-weight: 600;
    line-height: 140%;    
  }  
  .top-text{
    font-size: 18px;
    max-width: 513px;
    font-style: normal;
    font-weight: normal;
    line-height: 150%;
  }
  .user-group-header{
    font-size: 18px;
    line-height: 110%;  
    text-transform: uppercase;
    font-weight: 600;
  }
  .label{
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
  }
  .value{
    font-size: 16px;
    color: rgba(0, 0, 0, 0.6);
  }
  .edit{
    text-decoration-line: underline;
    font-size: 20px;
  }
  .action{
    text-align: left;
    text-decoration-line: underline;
    font-size: 16px;
  }

  /* Desktop */
  @media screen and (min-width: 992px){
    .congratz{
      max-width: 770px;
      font-size: 50px;
    }    
    .top-text{
      max-width: 513px;
      font-size: 26px;
    }    
    .user-group-header{
      font-size: 30px;
    }    
  }
  


</style>