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
    <!-- <list-table :data="getDeliveries" :model="'order'" @paged="getOrders()"></list-table> -->



  </div>


</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    byId:null,
  }},
  computed:{
    ...mapGetters(['getDeliveries']),
  },
  mounted(){
    this.fetchDeliveries();
  },
  methods:{
    ...mapActions(['fetchDeliveries']),
     goById(){
      this.$router.push('/delivery/'+this.byId);
    }   
  },
}
</script>

<style>

</style>