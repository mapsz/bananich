<template>
<div>
  <!-- Title -->
  <h5>Заказы</h5>

  <!-- Data -->
  <div>Всего заказов: {{count}}</div>
  <div>Общая сумма: ₽{{summ}}</div>

  <!-- List -->
  <b-button v-b-toggle.user-order-list-collapse class="m-1">Список заказов</b-button>
  <b-collapse id="user-order-list-collapse">
    <ul>
      <li v-for='(order,i) in orders' :key='i' >
        <a :href='"/admin/order/"+order.id'>{{order.id}}</a>
        ₽{{order.total_result}}
        {{order.status}}
      </li>
    </ul>
  </b-collapse>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({user:'user/getOne',orders:'order/get'}),
    count: function(){
      if(!this.orders) return false;


      return this.orders.length;
    },
    summ: function(){
      if(!this.orders) return false;

      let summ = 0;
      this.orders.forEach((v) => {
        console.log(v.total_result);
        summ += v.total_result;
      });

      return summ;
    }
  },
  watch: {
    user: async function(){
      if(!this.user) return false;
      if(this.user.id == undefined || this.user.id == 0) return false;
      
      await this.addFilter({'customer_id' : this.user.id});
      await this.fetchOrders();
    },
  },
  async mounted(){
    //
  },
  methods:{
    ...mapActions({
      fetchOrders:'order/fetchData',
      addFilter:  'order/addFilter',
    }),
  },
}
</script>

<style>

</style>