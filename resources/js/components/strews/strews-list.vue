<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <!-- Menu -->
  <div class="row m-3 mb-2 order-menu justify-content-between">
    <date-menu @dateChanged="dateChanged" :p-active="true"></date-menu>
  </div>
  <!-- List -->
  <list-table :data="items" :model="'strews'"></list-table>
</div>
</template>

<script>
export default {
  data(){return{
    items:[],
      filters:{
        date:[],
      },
  }},
  mounted(){
    // this.getItems();
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