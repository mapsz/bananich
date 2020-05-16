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

    <button @click="getData()" class="mt-3 btn btn-primary">Список</button>
    <!-- List -->
    <list-table v-if="showList" :model="'delivery'"></list-table>


  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    showList:false,
    loadData:false,
    byId:null,
  }},
  mounted(){
    //
  },
  methods:{
    ...mapActions(['fetchDeliverys']),
    getData(){
      if(!this.loadData){
        this.fetchDeliverys();
        this.loadData = true;
      } 
      this.showList = !this.showList;
    },
    goById(){
      this.$router.push('/delivery/'+this.byId);
    }   
  },
}
</script>

<style>

</style>