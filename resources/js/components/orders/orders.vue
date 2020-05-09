<template>
<div>
  <gruzka-navbar></gruzka-navbar>

  <!-- <parse @ordersUpdated="getOrders"></parse> -->

  <!-- <orders-print :orders="data"></orders-print> -->

  <!-- Menu -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <date-menu :p-active="true"></date-menu>
  </div>
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <time-menu></time-menu>
    <status-menu></status-menu>
    <search-menu></search-menu>
  </div>

  <!-- List -->
  <div class="container-fluid" ref="orderList">
    <list-table :model="'order'"></list-table>
  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  // computed:mapGetters(['allData']),
  data() {
    return {
      // slot:{default: this.$createElement('loader-icon'),},
      // data:[],
      // pages:false,
      // filters:{
      //   date:[],
      //   time:[],
      //   search:'',
      //   status:[],
      // },
      // statuses:[],
      // statusEdit:0,
      // statusChosed:"",
    }
  },
  mounted(){
    // this.fetchOrders();
  },
  methods:{
    ...mapActions(['fetchOrders']),
    // async getOrders(){
    //   this.jugeAxPages = 1;
    //   let r = await this.jugeAx('/json/orders',{
    //         deliveryDate:{
    //           from:(this.filters.date.from) ? moment(this.filters.date.from,this.filters.date.format).format('YYYY-MM-DD') : false,
    //           to:(this.filters.date.to) ? moment(this.filters.date.to,this.filters.date.format).format('YYYY-MM-DD') : false,
    //         },
    //         deliveryTime:{
    //           from:(this.filters.time.from) ? this.filters.time.from : false,
    //           to:(this.filters.time.to) ? (this.filters.time.to) : false,
    //         },
    //         search:this.filters.search,
    //         status:this.filters.status,
    //       }
    //     );
    //   if(r){
    //     this.data = r;
    //     this.pages = this.lastResponsePages;
    //   } 
    // },
    // dateChanged(date){
    //   this.filters.date = date;
    //   this.getOrders();
    // },
    // timeChanged(time){
    //   this.filters.time = time;
    //   this.getOrders();
    // },
    // statusChanged(status){
    //   this.filters.status = status;
    //   this.getOrders();
    // },
    // doSearch(search){
    //   this.filters.search = search;
    //   this.getOrders();
    // },
  }
}
</script>

<style>

</style>



