<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>


  <!-- Menu -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <date-menu @dateChanged="dateChanged" :p-active="true"></date-menu>
  </div>
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <time-menu @timeChanged="timeChanged"></time-menu>
    <status-menu @statusChanged="statusChanged"></status-menu>
    <item-status-menu @itemStatusChanged="itemStatusChanged"></item-status-menu>
    <search-menu @doSearch="doSearch"></search-menu>
  </div>

  <!-- List -->
  <!-- <div class="container-fluid" ref="orderList">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th>
            Название
          </th>
          <th>
            Сумма
          </th>
          <th>
            Заказы
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.name">
          <td>{{item.name}}</td>
          <td>{{item.summ}}</td>
          <td>{{item.orders}}</td>
        </tr>
      </tbody>
    </table>
  </div> -->
  <div class="container-fluid">
    <!-- <juge-list :data="'item'"></juge-list> -->
    <juge-list :data="items"></juge-list>
  </div>

  

</div>
</template>

<script>
export default {
  data() {
    return {
      slot:{default: this.$createElement('loader-icon'),},
      items:[],
      filters:{
        date:[],
        time:[],
        search:'',
        status:'',
        itemStatus:null,
      },      
    }
  },
  mounted(){
    //
  },
  methods:{
    async getItems(){

      let r = await this.jugeAx('/json/items',{
            deliveryDate:this.filters.date,
            deliveryTime:this.filters.time,
            search:this.filters.search,
            status:this.filters.status,
            itemStatus:this.filters.itemStatus,
      });      

      if(r) this.items = r;


    },
    dateChanged(date){
      this.filters.date = date;
      this.getItems();
    },
    timeChanged(time){
      this.filters.time = time;
      this.getItems();
    },
    statusChanged(status){
      this.filters.status = status;
      this.getItems();
    },
    itemStatusChanged(status){
      this.filters.itemStatus = status;
      this.getItems();
    },
    doSearch(search){
      this.filters.search = search;
      this.getItems();
    },
  }
}
</script>

<style>

</style>



