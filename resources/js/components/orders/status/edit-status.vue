<template>
<div class="input-group my-2">
  <select v-model="status" class="custom-select" id="order-status">
    <option 
      v-for="s in statuses" 
      :key="s.id" 
      :value="s.id"
    >
      {{s.name}}
    </option>              
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-success"  @click="putStatus(status)">Сохранить</button>      
  </div>
</div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
props: ['current-status','order-id'],
data(){return{
  statuses:[],
  status:null,
}},
watch: {
  currentStatus: function($new,$old){this.status=$new;},
},
async mounted(){
  await this.getStatuses(); 
},
methods:{
  async getStatuses(){
    let r = await this.jugeAx('/json/order/statuses');
    if(!r) return;
    this.statuses = r;
  },
  ...mapActions({'putStatus':'order/putStatus'}),
},
}
</script>

<style>

</style>