<template>
<div class="container-fluid">
  <div class="parse" ref="parse">
    <button class="btn btn-warning my-2" @click="parse()">
      Parse
    </button>
    <span class="parse-info">
      <span v-if="result.orderCount" class="text-primary">
        {{result.orderCount}}
      </span>
      <span v-if="result.putOrderCount" class="text-success">
        {{result.putOrderCount}}/{{result.itemsCount}}
      </span>
    </span>
  </div>
</div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
  data() {
    return {
      result:[],
    }
  },
  methods:{
    ...mapActions(['fetchOrders']),
    async parse() {
      let r = await this.jugeAx('/parse/orders');
      if(r){
        this.result = r;
        this.fetchOrders();
      }
    },
  }
}
</script>

<style>

</style>