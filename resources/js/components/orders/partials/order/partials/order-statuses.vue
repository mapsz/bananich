<template>
<div>
  <!-- Title / EditButton -->
  <span class="d-flex justify-content-between">
    <h5>История заказа</h5>
    <font-awesome-icon 
      @click="edit = !edit"
      class="mr-3" 
      icon="edit" 
      color="#ff8d00"
      style="cursor:pointer"
    />
  </span>  

   <!-- Edit Status -->
  <div v-show="edit" id="order-statuses-edit">
    <edit-status 
      :current-status="order.statuses != undefined ? order.statuses[0].id : null"
      :order-id="order.id"
    ></edit-status>
  </div>   

  <!-- Current Status / Toggle Button -->
  <div class="row justify-content-between m-0">
    <!-- Current Status -->
    <span v-if="order.statuses && order.statuses[0]" class="align-self-center" >
      {{order.statuses[0].name}}
    </span>
    <!-- Toggle Button -->
    <a data-toggle="collapse" href="#" data-target="#order-statuses-history">
      <font-awesome-icon icon="bars" size="2x"/> 
    </a>
  </div>

  <!-- Status History -->
  <div class="order-statuses collapse" id="order-statuses-history">
    <span v-for="(status, i) in order.statuses" :key="i">
      <div class="d-flex border-bottom justify-content-between">
        <div>
          <div>
            {{status.name}}
          </div>
          <div>
            {{status.pivot.created_at}}
          </div>
        </div>
        <div v-if="status.user != undefined" class="align-self-center">
          {{status.user.name}}
        </div>
      </div>
    </span>
  </div>      

</div>  
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  data(){return{
    edit:false,
    showHistory:true,
  }},
  computed:{
    ...mapGetters({order:'getOrder'},),
  },
  mounted(){
    // 
  },
}
</script>

<style scoped>
.order-statuses{
  border-top:2px dashed black;
}
</style>