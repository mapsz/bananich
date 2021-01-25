<template>
  <div>
    <div v-if="maxCount" class="shared-order-open-container">      
      <div v-for="(n, i) in maxCount" :key="i" class="shared-order-open-block mb-3">

        <div v-if="(inviteSOrder && inviteSOrder.member_count > 0) && inviteSOrder.member_count == n" class="shared-order-open-announce">
          <span class="info-icon"></span> 
          <span class="shared-order-open-announce-text ml-2">Вы приглашены в эту закупку</span>        
        </div>

        <div class="d-flex d-lg-block">

          <!-- Price -->
          <div class="price">
            {{(price / n).toFixed(0)}}p
          </div>

          <div>
            <!-- Members -->
            <div class="member-count">
              на <b>{{n}}</b> участника закупки
            </div>
            <!-- Wight -->
            <div class="max-weight">
              <b>макс. вес</b> - {{(weight / n).toFixed(2).replace('.00', "")}} кг. 
            </div>     
          </div>   
        </div>
        
        <!-- Button -->
        <div class="d-flex justify-content-center shared-order-open-button">

          <a v-if="(invite && (inviteOrder.status_id == 100 || inviteOrder.status_id == 200)) && inviteOrder.member_count == n" :href="'/shared/order/' + inviteSOrder.link">
            <button   
              class="x-btn"
            >
              Присоединиться к закупке
            </button>
          </a>

          <a v-else :href="'/shared/order?pre='+n">
            <button 
              class="x-btn"
            >
              Открыть закупку
            </button>
          </a>
        </div>

      </div>  
    </div>
    <div class="d-flex justify-content-center">
      *Организационный сбор будет включен в вашу накладную, которую можно оплатить по факту доставки
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  //
}},
computed:{  
  ...mapGetters({
    sOrders:    'sharedOrder/get',
    user:       'user/get',
    settings:   'settings/beautyGet',
    invite:     'sharedOrder/getInviteLink',
    inviteOrder:    'sharedOrder/getInviteOrder',
  }),
  inviteSOrder(){
    if(this.sOrders == undefined || this.sOrders.length < 1) return false;
    return this.sOrders[0];
  },
  maxCount(){
    if(this.settings == undefined || this.settings.x_max_member_count  == undefined) return false;
    return this.settings.x_max_member_count;
  },
  price(){
    if(this.settings == undefined || this.settings.x_order_price  == undefined) return false;
    return this.settings.x_order_price;
  },
  weight(){
    if(this.settings == undefined || this.settings.x_order_weight  == undefined) return false;
    return this.settings.x_order_weight;
  }
},
watch:{
  invite: function (val, oldVal) {  
    this.getInvite();
  },
},
async mounted() {
  this.getInvite();
},
methods:{  
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
  }),
  async getInvite(){
    console.log(this.invite);
    if(this.invite == undefined || !this.invite) return false;
    if(this.invite){
      await this.filter({'link':this.invite});
      await this.get(); 
    }
  }
},
}
</script>

<style scoped>

.shared-order-open-block{
  width:100%;
  background-color: white;
  box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);
  border-radius: 2px;
  border-left: 7px solid black;
  font-size: 16px;
  line-height: 140%;
  padding-top:11px;
  padding-bottom:14px;
}

.shared-order-open-block .price{  
  align-self: center;
  margin-left: 16px;
  margin-right: 20px;
  font-weight: 600;
  font-size: 30px;
}

.shared-order-open-block .price:after{  
  content: '*';
  position: absolute;
  font-size: 16px;
}

.shared-order-open-block .member-count{    
  font-size: 16px;
  line-height: 140%;
  margin-bottom:5px;
}

.shared-order-open-block .max-weight{    
  font-size: 16px;
  line-height: 140%;
}

.shared-order-open-button .x-btn{    
  height: 40px;
  margin-top: 10px;
}

.shared-order-open-announce{
  display: flex;
  justify-content: center;
  align-items: center;    
}

.shared-order-open-announce-text{
  font-size: 14px;
  color: gray;
  font-style: italic;
}


/* Desktop */
@media screen and (min-width: 992px){

  .shared-order-open-block .price:after{  
    content: '*';
    position: relative;
    left: -16px;
    top: -24px;
    font-size: 20px;
  }

  .shared-order-open-announce{    
    display: flex;
    position: relative;
    background-color: #8ac2a7;
    color: black;
    width: fit-content;
    height: 40px;
    border-radius: 100px;
    bottom: 15px;
    left: 55px;
    margin-top: -40px;
  }

  .shared-order-open-announce .info-icon{
    display: none;
  }

  .shared-order-open-announce-text{
    font-size: 16px;
    color: black;
    font-style: normal;
    margin: 0 10px;
  }

  .shared-order-open-block{
    width:320px;
    display: inline-block!important;    
    border-left: 0px solid black;  
    border-top: 10px solid black;
    margin-left:5px;
    margin-right:5px;
  }

  .shared-order-open-container{
    display: flex;
    justify-content: space-around;
  }

  .shared-order-open-block{
    padding: 35px;
    padding-top: 25px;
    text-align: center;
  }

  .shared-order-open-block .price{
    font-size: 50px;
    line-height: 130%;
  }

  .shared-order-open-block .member-count{
    margin-top:16px;
    font-size: 20px;
    line-height: 140%;
  }

  .shared-order-open-block .max-weight{
    font-size: 24px;
    line-height: 140%;
    margin-bottom:25px;
  }

  .shared-order-open-button .x-btn{    
    height: 60px;
    margin-top: 0px;
  }
  
}

</style>