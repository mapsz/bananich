<template>
<div>

  <!-- List -->
  <div class="container" ref="orderList">    
    <h2>{{today}}</h2>
    <div v-for='(order,i) in fOrders' :key='i' > 
      <span><b>Заказ № {{order.id}}</b> </span>
      <ul>
        <li v-for='(item,j) in order.termoItems' :key='j' > 
          {{item.quantity_result == null ? 0 : quantity_result}} {{item.name}}
        </li>
      </ul>
    </div>
  </div>
  
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    today:moment().format('YYYY-MM-DD'),
  }},
  computed:{
    ...mapGetters({orders:'order/get'}),
    fOrders:function(){
      if(this.orders == undefined || this.orders[0] == undefined) return [];

      let orders = [];
      let items = [];

      $.each(this.orders, (k, order) => { 
        items = [];       
        $.each(order.items, (k, item) => {
          if(item.termobox != undefined && item.termobox)
            items.push(item);
        });
        if(items.length > 0){
          let push = order;
          push.termoItems = items;
          orders.push(push);
        }

      });

      return orders;
    }
  },
  async mounted(){
    await this.addFilter({no_pages:1})
    await this.addFilter({deliveryDate:{from:'2020-09-27',to:'2020-09-27'}})
    // await this.addFilter({deliveryDate:{from:this.today,to:this.today}})
    await this.fetch();
  },
  methods:{    
    ...mapActions({'addFilter':'order/addFilter','fetch':'order/fetchData'}),
  },

}
</script>

<style>

</style>