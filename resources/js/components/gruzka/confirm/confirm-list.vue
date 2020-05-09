<template>
<div class="container-fluid">
  <!-- Navbar -->
  <gruzka-navbar></gruzka-navbar>

  <!-- Title -->
  <h1>Подтверждение</h1>

  <!-- Menu -->
  <div>
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <date-menu @dateChanged="dateChanged"></date-menu>
    </div>
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <time-menu @timeChanged="timeChanged"></time-menu>
      <search-menu @doSearch="doSearch"></search-menu>
    </div>
  </div>

  <!-- List -->
  <table class="table table-sm">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Items</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col">Address</th>
        <th scope="col">Comment</th>
        <th scope="col">Status</th>
        <th scope="col">Confirm</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="order in orders" :key="order.id">
        <th scope="row">
          <router-link :to="'/order/'+order.id">{{order.id}}</router-link>            
        </th>
        <td>{{order.items.length}}</td>
        <td style="width:100px">
          {{order.delivery_date}}
        </td>
        <td style="width:150px">
          {{order.delivery_time_from}} - {{order.delivery_time_to}}
        </td>
        <td>{{order.address}}</td>
        <td>{{order.comment}}</td>
        <td>{{order.statuses[0].name}}</td>
        <td>
          <a :href="'/confirm/order/'+order.id">
            <font-awesome-icon 
              class="text-primary" 
              icon="check-square" 
              size="2x"
            />
          </a>
        </td>
      </tr>
    </tbody>
  </table>  

</div>
</template>

<script>
export default {
  data() {
    return {
      orders:[],
      filters:{
        date:[],
        time:[],
        search:'',
      },
    }
  },
  mounted(){
    // this. getOrders();
  },
  methods:{
    async getOrders(){
      let r = await this.jugeAx('/json/orders',{
            deliveryDate:{
              from:(this.filters.date.from) ? moment(this.filters.date.from,this.filters.date.format).format('YYYY-MM-DD') : false,
              to:(this.filters.date.to) ? moment(this.filters.date.to,this.filters.date.format).format('YYYY-MM-DD') : false,
            },
            deliveryTime:{
              from:(this.filters.time.from) ? this.filters.time.from : false,
              to:(this.filters.time.to) ? (this.filters.time.to) : false,
            },
            search:this.filters.search,
            status:[900,850,800,700],
          }
        );
      if(r) {this.orders = r}
    },
    dateChanged(date){
      this.filters.date = date;
      this.getOrders();
    },
    timeChanged(time){
      this.filters.time = time;
      this.getOrders();
    },
    doSearch(search){
      this.filters.search = search;
      this.getOrders();
    },
  }

}
</script>

<style>

</style>