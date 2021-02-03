<template>
<div>
  <!-- Not Shared order page -->
  <template v-if="$route.name != 'sharedOrder' && $route.name != 'sharedOrderOpen'">    
    <!-- My order exists -->
    <template v-if="myOrder && myOrder.id != undefined"> 
      <!-- Order Confirm -->
      <template v-if="confirm">
        <button @click="goToOrder()" class="x-btn">
          К моей закупке
        </button>
      </template>
      <!-- Order not confirm -->
      <template v-else>
        <button @click="goToOrder()" class="x-btn">
          Завершить оформление заказа
        </button>
      </template>
    </template>
    <!-- My order Not exists -->
    <template v-else>
      <!-- Invite -->
      <template v-if="invite && (inviteOrder.status_id == 100 || inviteOrder.status_id == 200)">
        <button @click="goToInvite()" class="x-btn">
          Присоединиться к закупке
        </button>
      </template>
    </template>
  </template>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {

computed:{
  ...mapGetters({
    user:       'user/get',
    myOrder:    'sharedOrder/getMyOrder',
    inviteOrder:    'sharedOrder/getInviteOrder',
    invite:    'sharedOrder/getInviteLink',
  }),
  confirm(){
    if(this.user == undefined && !this.user) return false;
    if(!this.myOrder || this.myOrder.orders == undefined || this.myOrder.orders.length <= 0) return false;

    let order = this.myOrder.orders.find(x => x.customer_id == this.user.id);
    if(!order || order.x_confirm == undefined) return false
    return order.x_confirm;    
  },
},
async mounted() {
  this.getInviteOrder();
},

methods:{  
  ...mapActions({
    'getInviteOrder':'sharedOrder/fetchInviteOrder',
  }),  
  goToInvite(){
    location.href = '/shared/order/' + this.invite;
  },
  goToOpen(){
    location.href = '/shared/order';
  },
  goToOrder(){
    location.href = '/shared/order/' + this.myOrder.link;
  },
},
}
</script>

<style scoped>


@media screen and (max-width: 991px){
  .x-btn{
    padding: 0px 15px;
  }
}

</style>