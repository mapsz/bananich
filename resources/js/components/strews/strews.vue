<template>
<div>
  <gruzka-navbar></gruzka-navbar>  
  <product-navbar></product-navbar>
  <div class="container-fluid">
    <!-- Filters -->
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <juge-date-filter :model="'item'"></juge-date-filter>
    </div>
    <!-- List -->
    <juge-list :data="'item'" :keys="'strews'" :disable-auto-fetch="true"></juge-list>
  </div>
</div>
</template>

<script>
export default {
  mounted(){
    //Set filters
    this.$store.dispatch('item/addFilter',{status:[600,500]});
    this.$store.dispatch('item/addFilter',{piece:1});
    this.$store.dispatch('item/addFilter',{strews:1});
    //Fetch
    this.$store.dispatch('item/listFetch');
  },
  methods:{
    async getItems(){
      let r = await this.jugeAx('/json/items',{
        piece:1,
        deliveryDate:{
          from:(this.filters.date.from) ? moment(this.filters.date.from,this.filters.date.format).format('YYYY-MM-DD') : false,
          to:(this.filters.date.to) ? moment(this.filters.date.to,this.filters.date.format).format('YYYY-MM-DD') : false,
        },
        status:[600,500],
        strews:1,
      })
      if(!r) return;
      this.items = r;
    },
    dateChanged(date){
      this.filters.date = date;
      this.getItems();
    },    
  },
}
</script>

<style>

</style>