<template>
<div v-if="$route.name != 'sharedOrder' && $route.name != 'sharedOrderOpen'">
  <button v-if="myOrder.id == undefined && invite && (inviteOrder.status_id == 100 || inviteOrder.status_id == 200)" @click="goToInvite()" class="x-btn">
    Присоединиться к закупке
  </button>
  <button v-else-if="myOrder && myOrder.id != undefined" @click="goToOrder()" class="x-btn">
    К моей закупке
  </button>
  <!-- <button v-else @click="goToOpen()" class="x-btn">
    Открыть закупку
  </button> -->
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