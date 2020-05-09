<template>
  <div class="container-fluid">
    <gruzka-navbar></gruzka-navbar>

    <h1>Call {{date}}</h1>
    
    <!-- Call -->
    <div class="row m-0 mb-3">
      <span class="align-self-center"><b>Orders:</b> {{orders.length}}</span>
      <router-link v-if="orders.length > 0" :to="'/call/order/'+orders[0].id">
        <button class="btn btn-primary mx-3">Call</button>
      </router-link>
    </div>

    <table class="table table-sm">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Items</th>
          <th scope="col">Time</th>
          <th scope="col">Call</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <th scope="row">
            <router-link :to="'/order/'+order.id">{{order.id}}</router-link>            
          </th>
          <td>{{order.items.length}}</td>
          <td>{{order.delivery_time_from}} - {{order.delivery_time_to}}</td>
          <td>      
            <router-link  :to="'/call/order/'+order.id">
              <button class="btn btn-primary mx-3">Call {{order.id}}</button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Call -->
    <div class="row m-0 mb-3">
      <span class="align-self-center"><b>Orders:</b> {{Object.keys(orders).length}}</span>
      <router-link v-if="orders.length > 0" :to="'/call/order/'+orders[0].id">
        <button class="btn btn-primary mx-3">Call</button>
      </router-link>
    </div>    

  </div>
</template>

<script>
export default {
  data() {
    return {
      slot:{default: this.$createElement('loader-icon'),},
      orders:[],
      date:moment().format('DD.MM'),
    }
  },
  mounted(){    
    this.getOrders();
  },
  methods:{ 
    async getOrders(){
      let l = this.$loading.show({},this.slot);
      let r = await axios.get('/json/orders',{
        params:{
            deliveryDate:{
              from:moment().format('YYYY-MM-DD'),
              to:moment().format('YYYY-MM-DD')
            },          
            status:800,
          }
        })
        .then((r)=>{
          this.orders = Object.values(r.data.data);
        }) 
        
      l.hide();
    },
  }
}
</script>

<style>

</style>