<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  <driver-navbar></driver-navbar>
    
  <div class="container-fluid" ref="orderList">

    <h2>Выдача</h2>  
    <!-- By id -->
    <form @submit.prevent="goById()" class="input-group mb-3" style="width: 280px;">    
      <input v-model="byId" type="number" class="form-control">
      <div class="input-group-append">
        <button @click.prevent="goById()" class="btn btn-outline-primary px-1" type="button">По ID</button>
      </div>     
    </form> 

    <!-- Title -->
    <h4>Логистика</h4>  

    <!-- Filter -->
    <juge-date-filter :model="'logistic'"/>

    <!-- Orders Left -->
    <div style="font-size:16pt">
      <!-- no orders -->
      <span v-if="ordersLeft == -2" class="text-info">На указаную дату заказов не найдено</span>
      <!-- left -->
      <span v-if="ordersLeft > 0" class="text-warning">Заказов не оформлено: <b>{{ordersLeft}}</b></span>
      <!-- Success -->
      <span v-if="ordersLeft == 0" class="text-success"><b>Все заказы успешны!</b></span>
    </div>

    <!-- List -->
    <juge-list v-if="driverKeys" class="mt-3" :data="'logistic'" :keys="driverKeys"/>
  </div>


</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    driverKeys:false,
    showList:false,
    loadData:false,
    byId:null,
  }},
  computed:{
    ...mapGetters({orders:'logistic/get',isFetched:'logistic/isFetched'}),
    ordersLeft(){
      if(!this.isFetched) return -1;
      if(this.isFetched && this.orders.length == 0) return -2;

      let count = 0;
      $.each(this.orders, function(k,v){
        if(v.order.statuses[0] == undefined) return;
        if(v.order.statuses[0].id == 1) count++;
      });

      return this.orders.length - count;
    },
  },
  mounted(){
    if(this.$route.params.drivers == undefined || this.$route.params.drivers != 'all'){
      this.$store.dispatch('logistic/addFilter',{driver_build:1});
    }
    
    this.getDriverKeys();
  },
  methods:{
    getData(){
      if(!this.loadData){
        //Fetch
        // this.$store.dispatch('order/listFetch');
        this.loadData = true;
      } 
      this.showList = !this.showList;
    },
    goById(){
      this.$router.push('/driver/delivery/'+this.byId);
    },
    async getDriverKeys(){
      this.driverKeys = await ax.fetch('/driver/logistic/keys');
    }
  },





    // <!-- List -->
    // <button @click="getData()" class="mt-3 btn btn-primary">Список</button>

    // <div v-if="showList">

    //   <!-- Filters -->
    //   <div class="row m-3 mb-2 order-menu justify-content-between">
    //     <juge-date-filter :model="'order'" :default="false"></juge-date-filter>
    //     <id-filter :model="model"></id-filter>
    //   </div>      
    //   <div class="row m-3 mb-2 order-menu justify-content-between">
    //     <order-delivery-time-filter :model="'order'" />
    //     <search-filter  :model="'order'" />
    //   </div>

    //   <juge-list  :data="'order'" :keys="'delivery'" />
    //   <!-- <juge-list v-if="showList" :data="'order'" :keys="'delivery'" :disable-auto-fetch="true"/> -->

    // </div>



}
</script>

<style>

</style>