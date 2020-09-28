<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>

  <div class="container-fluid">
    <!-- By id -->
    <form @submit.prevent="goById()" class="input-group" style="width: 140px;">    
      <input v-model="byId" type="number" class="form-control">
      <div class="input-group-append">
        <button @click.prevent="goById()" class="btn btn-outline-primary px-1" type="button">По ID</button>
      </div>     
    </form> 

    <!-- List -->
    <button @click="getData()" class="mt-3 btn btn-primary">Список</button>

    <div v-if="showList">

      <!-- Filters -->
      <div class="row m-3 mb-2 order-menu justify-content-between">
        <juge-date-filter :model="'order'" :default="false"></juge-date-filter>
        <id-filter :model="model"></id-filter>
      </div>      
      <div class="row m-3 mb-2 order-menu justify-content-between">
        <order-delivery-time-filter :model="'order'" />
        <search-filter  :model="'order'" />
      </div>

      <juge-list  :data="'order'" :keys="'delivery'" />
      <!-- <juge-list v-if="showList" :data="'order'" :keys="'delivery'" :disable-auto-fetch="true"/> -->

    </div>

  </div>

</div>
</template>

<script>
export default {
  data(){return{
    showList:false,
    loadData:false,
    byId:null,
  }},
  mounted(){
    //Set filters
    this.$store.dispatch('order/addFilter',{status:[1]});
  },
  methods:{
    getData(){
      if(!this.loadData){
        //Fetch
        this.$store.dispatch('order/listFetch');
        this.loadData = true;
      } 
      this.showList = !this.showList;
    },
    goById(){
      this.$router.push('/admin/delivery/'+this.byId);
    }   
  },
}
</script>

<style>

</style>