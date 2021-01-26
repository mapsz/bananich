<template>
<div v-if="isX">
  <div v-if="announces.length > 0" class="announces-block py-3">
    <div class="container p-0">
      <div v-for="(announce, i) in announces" :key="i"  class="announce mx-3">
        <div class="d-flex align-items-center justify-content-between w-100">
          <div>
            <span v-if="announce.created_at" class="announce-time">{{moment(announce.created_at).locale("ru").format('LLL')}}</span>
            <span class="announce-body" v-html="announce._body" />
          </div>
          
          <div v-if="announce.status != undefined && announce.status == 1" 
            @click="doDelete(announce.id)" 
            class="d-inline-block ml-3" style="cursor: pointer;"
          >
            <div class="d-flex">
              <div class="info-icon info-icon-cancel" />
            </div>         
          </div>        
        </div>      
      </div>
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  isX:isX,
  moment:moment,
  fetchrdAnnounces:[],
}},
computed:{
  ...mapGetters({
    cart:       'cart/getCart',
    sOrders:    'sharedOrder/get',
    myOrder:    'sharedOrder/getMyOrder',
    inviteOrder:    'sharedOrder/getInviteOrder',
    invite:     'sharedOrder/getInviteLink',
    settings:   'settings/beautyGet',
    user:       'user/get',
  }), 
  announces(){
    if(!this.fetchrdAnnounces) return [];

    //Statics
    let statics = [];
    if(
      this.$route.name == 'catalogue' && 
      (this.sOrders && this.sOrders[0] == undefined)
    ){
      statics.push(
        {'_body':'Обратите внимание, что в накладную будет также включен организационный сбор. С тарифами можно ознакомиться <a href="/welcome">тут</a>'}
      );
    }

    // TODO @@@
    // if( 
    //   this.$route.name == 'sharedOrderOpen' && 
    //   (this.cart && this.cart.items != undefined && this.cart.items[0] != undefined)
    // ){
    //   statics.push(
    //     {'_body':'Обратите внимание, что в накладную будет также включен организационный сбор. С тарифами можно ознакомиться <a href="/welcome">тут</a>'}
    //   );
    // }

    if(
      (this.isAdmin && this.sOrder.users.length < 2)
    ){
      statics.push(
        {'_body':'Вы можете внести изменения в адрес доставки, дату и время доставки пока никто в нее не вступил'}
      );
    }

    if(
      this.sOrder.id != undefined && this.allConfirmed != 1 && (this.untilClose / 60 / 60) < 2
    ){
      statics.push(
        {'_body':'<a href="/shared/order/'+this.myOrder.link+'">Кто-то из участников</a> еще не оформил свой заказ. Напоминаем, что это необходимо сделать до '+ moment(this.sOrder.order_close).locale("ru").format('LT')}
      );
    }

    if(
      (this.$route.name == 'sharedOrder' || this.$route.name == 'cart') &&
      (this.overWeightKg > 0) &&
      this.settings
    ){
      statics.push(
        {'_body':'Вы превысили допустимый лимит веса заказа на '+this.overWeightKg.toFixed(2)+' кг. Каждые дополнительные '+this.settings.x_weight_step_kg+' кг оплачиваются отдельно в сумме '+this.settings.x_weight_step_price+' р за '+this.settings.x_weight_step_kg+' кг'}
      );
    }

    if(
      (this.cart && this.cart.items != undefined && this.cart.items[0] != undefined) &&
      (this.sOrder.id != undefined && !this.confirm)
    ){
      statics.push(
        {'_body':'Напоминаем, что необходимо <a href="/shared/order/checkout/'+this.myOrder.link+'">завершить оформление</a> заказа до '+ moment(this.sOrder.order_close).locale("ru").format('LLL')}
      );
    }

    if(
      (this.$route.name != 'sharedOrder') &&
      (this.invite != undefined && this.invite) && 
      (inviteOrder.status_id == 100 || inviteOrder.status_id == 200) && 
      !this.myOrder
    ){
      statics.push(
        {'_body':'Вы приглашены принять участие в <a href="/shared/order/'+this.invite+'">совместной закупке</a> на Neo Lavka'}
      );
    }

    

    return statics.concat(this.fetchrdAnnounces);
  },  
  sOrder(){
    return this.myOrder;
  },
  isAdmin(){
    if(this.user == undefined && !this.user) return false;
    if(!this.sOrder || this.sOrder.owner_id == undefined || this.sOrder.owner_id < 1) return false;
    if(this.user.id == this.sOrder.owner_id) return true;
    return false;
  },
  untilClose(){
    if(this.sOrder == undefined || this.sOrder.order_close == undefined) return false;
    return moment(this.sOrder.order_close).unix() - moment().unix();
  },
  allConfirmed(){
    let c = -1;
    if(!this.sOrder || this.sOrder.orders == undefined || this.sOrder.orders.length <= 0) return c;    
    c = 1;
    this.sOrder.orders.forEach(order => {
      if(!order.x_confirm) c = 0;
    });
    return c;
  },
  overWeightKg(){
    if(this.cart == undefined || this.cart.xData == undefined || this.cart.xData.overWeightKg == undefined) return false;
    return this.cart.xData.overWeightKg;
  },
  confirm(){
    if(this.user == undefined && !this.user) return false;
    if(!this.sOrder || this.sOrder.orders == undefined || this.sOrder.orders.length <= 0) return false;

    let order = this.sOrder.orders.find(x => x.customer_id == this.user.id);
    if(!order || order.x_confirm == undefined) return false
    return order.x_confirm;    
  },
},
async mounted() {
  this.get();
},
methods:{
  async get(){
    let r = await ax.fetch('/announce/auth');
    if(r) this.fetchrdAnnounces = r;
  },
  async doDelete(id){
    let r = await ax.fetch('/announce',{id},'delete');
    this.get();
  },
},
}
</script>

<style>
  .announces-block{
    background-color: #e7dfdc;
    font-size: 14px;
    line-height: 115%;
  }  
  .announce-time{
    background-color: #e7dfdc;
    font-size: 12px;
    line-height: 115%;
  }  
  .announce{
    border-bottom: 1px solid #00000038;
    padding-bottom: 10px;
    margin-bottom: 10px;
  }
  .announce:last-child{    
    border-bottom: 0px solid black;
    padding-bottom: 0px;
    margin-bottom: 0px;
  }
  .announce a{
    color:black !important;
    text-decoration: underline;
  }
  .announce-body{
    display: block; 
  }
  
  /* Desktop */
  @media screen and (min-width: 992px){
    .announces-block{
      font-size: 18px;
    }
  .announce-time{
    font-size: 14px;
  }  
  }
</style>