<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <!-- Menu -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <date-menu class="mt-2" @dateChanged="dateChanged" :p-active="true"></date-menu>
    <status-menu class="mt-2" @statusChanged="statusChanged"></status-menu>
  </div>
  <!-- No items -->
  <div class="container" v-if="data.order == undefined">
    Нет заказов
  </div>
  <div v-else>
    <!-- List Order-->
    <list-table :data="[data.order]" :model="'statisticsOrder'"></list-table>
    <!-- List Items-->
    <list-table :data="data.products" :model="'statisticsProducts'"></list-table>
  </div>
</div>
</template>

<script>
export default {
  data(){return{
    data:[],
    filters:{
      date:[],
      status:[],
    },
  }},
  mounted(){
    // this.getItems();
  },
  methods:{
    async get(){
      let r = await this.jugeAx('/json/statistics',{
        piece:1,
        deliveryDate:{
          from:(this.filters.date.from) ? moment(this.filters.date.from,this.filters.date.format).format('YYYY-MM-DD') : false,
          to:(this.filters.date.to) ? moment(this.filters.date.to,this.filters.date.format).format('YYYY-MM-DD') : false,
        },
        status:this.filters.status,
      })
      if(!r) return;
      this.data = r;
    },
    dateChanged(date){
      this.filters.date = date;
      this.get();
    },    
    statusChanged(status){
      this.filters.status = status;
      this.get();
    },
  },
}
</script>

<style>

</style>