<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <report-menu></report-menu>

  <div class="container-fluid">

    <!-- Filters -->
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <juge-date-filter :model="model"></juge-date-filter>
    </div>
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <order-delivery-time-filter :model="model" />
      <order-status-filter  :model="model" />
      <item-status-filter  :model="model" />
      <search-filter  :model="model" />
    </div>

    <!-- List -->
    <juge-list :data="model"></juge-list>

  </div>
  

</div>
</template>

<script>
export default {
  data(){return{
    model:'item'
  }},
  // data() {
  //   return {
  //     slot:{default: this.$createElement('loader-icon'),},
  //     items:[],
  //     filters:{
  //       date:[],
  //       time:[],
  //       search:'',
  //       status:'',
  //       itemStatus:null,
  //     },      
  //   }
  // },
  // mounted(){
  //   //
  // },
  // methods:{
  //   async getItems(){

  //     let r = await this.jugeAx('/json/items',{
  //           deliveryDate:this.filters.date,
  //           deliveryTime:this.filters.time,
  //           search:this.filters.search,
  //           status:this.filters.status,
  //           itemStatus:this.filters.itemStatus,
  //     });      

  //     if(r) this.items = r;


  //   },
  //   dateChanged(date){
  //     this.filters.date = date;
  //     this.getItems();
  //   },
  //   timeChanged(time){
  //     this.filters.time = time;
  //     this.getItems();
  //   },
  //   statusChanged(status){
  //     this.filters.status = status;
  //     this.getItems();
  //   },
  //   itemStatusChanged(status){
  //     this.filters.itemStatus = status;
  //     this.getItems();
  //   },
  //   doSearch(search){
  //     this.filters.search = search;
  //     this.getItems();
  //   },
  // }
}
</script>

<style>

</style>



