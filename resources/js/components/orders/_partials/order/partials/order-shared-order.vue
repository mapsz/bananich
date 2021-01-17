<template>
<div v-if="sOrder">
  <div><b>NEO</b></div>
  <div>Закрытие: {{moment(sOrder.order_close).locale("ru").format('LLL')}}</div>
  <div>Организатор: <a :href="'/admin/user'+ owner.id"> {{owner.id}}</a> {{owner.name}} </div>
  <div>
    <div>Заказы:</div>
    <div v-for="(order, index) in sOrder.orders" :key="index" class="ml-2">
      <a :href="'/admin/order'+ order.id" style=""><span v-if="order.customer_id == owner.id">👑</span> {{order.id}}</a>
    </div>
  </div>

</div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
props: ['s-order-id'],
data(){return{
  moment:moment,
}},
computed:{
  ...mapGetters({
    sOrders:    'sharedOrder/get',
  }), 
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
},
watch:{
  sOrderId: async function (val, oldVal) {
    this.get();
  },
},
async mounted() {  
  this.get();
},
methods:{  
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'fetch':'sharedOrder/fetchData',
  }),
  async get(){
    if(this.sOrders.id == undefined && this.sOrderId > 0){
      await this.filter({'id':this.sOrderId});
      await this.fetch();
    }
  }
},
}
</script>

<style>

</style>