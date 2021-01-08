<template>
<div v-if="$route.name != 'sharedOrder'">
  <button v-if="!myOrder && invite" @click="goToInvite()" class="x-btn">Присоединиться к закупке</button>
  <button v-else-if="myOrder" @click="goToOrder()" class="x-btn">К моей закупке</button>
  <button v-else @click="goToOpen()" class="x-btn">Открыть закупку</button>
</div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {

computed:{
  ...mapGetters({
    user:'user/get',
    myOrder:    'sharedOrder/getMyOrder',
  }),
  invite(){
    return Cookies.get('x_invite');
  },
},

methods:{  
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

<style>

</style>