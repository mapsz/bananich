<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <div class="container-fluid">
    <!-- Filters -->
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <juge-date-filter :model="'statistic'"></juge-date-filter>
      <order-status-filter  :model="'statistic'" />
    </div>
    
    <!-- Lists -->
    <h3>Заказы</h3>
    <juge-list :data="order" :keys="orderKeys"/>
    <h3>Продукты</h3>
    <juge-list :data="products" :keys="productsKeys"/>

  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      keys:'statistic/getKeys',
      data:'statistic/get'
    }),
    order:function(){if(this.data.order==undefined)return [];else return [this.data.order];},
    products:function(){if(this.data.products==undefined)return [];else return this.data.products;},
    orderKeys:function(){if(this.keys==undefined||this.keys.order==undefined)return {};else return this.keys.order;},
    productsKeys:function(){if(this.keys==undefined||this.keys.products==undefined)return {};else return this.keys.products;},
  },
  mounted(){
    this.fetch();
  },
  methods:{
    ...mapActions({'fetch':'statistic/listFetch'}),

  //   async get(){
  //     let r = await this.jugeAx('/json/statistics',{
  //       piece:1,
  //       deliveryDate:{
  //         from:(this.filters.date.from) ? moment(this.filters.date.from,this.filters.date.format).format('YYYY-MM-DD') : false,
  //         to:(this.filters.date.to) ? moment(this.filters.date.to,this.filters.date.format).format('YYYY-MM-DD') : false,
  //       },
  //       status:this.filters.status,
  //     })
  //     if(!r) return;
  //     this.data = r;
  //   },
  //   dateChanged(date){
  //     this.filters.date = date;
  //     this.get();
  //   },    
  //   statusChanged(status){
  //     this.filters.status = status;
  //     this.get();
  //   },
  },
}
</script>

<style>

</style>