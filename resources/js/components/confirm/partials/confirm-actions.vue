<template>
<div 
  v-if="status.name != undefined"
  class="confirm-actions d-flex justify-content-between border-top border-bottom p-2"
>
  <!-- Date Status -->
  <span class="align-self-center">
    {{orderDate()}} <b>{{status.name}}</b>    
  </span>

  <!-- Buttons -->
  <div class="" style="display: flex;align-items: center;">
    <!-- Не поднимает трубку -->
    <button 
      v-if="
        confirm == 1 && 
        (
          status.id == 900 || 
          status.id == 850
        )" 
      @click="putStatus(850)"
      class="btn"
      :class="status.id == 850 ? 'btn-secondary' : 'btn-outline-secondary'"
      :style="status.id == 850 ? 'border: 3px solid limegreen;' : ''"
    >
      Не поднимает трубку
    </button>

    <!-- Потверждён по телефону -->
    <button 
      v-if="
        confirm == 1 && 
        (
          status.id == 900 || 
          status.id == 850
        )" 
      @click="putStatus(700)"
      class="btn btn-outline-primary"
    >
      Потверждён по телефону
    </button>

    <!-- Потверждён -->
    <button 
      v-if="
        (
          confirm == 0 && 
          status.id == 900
        ) ||
        (
          confirm == 1 && 
          status.id == 800
        )" 
      @click="putStatus(700)"
      class="btn btn-outline-info"
    >
      Потверждён
    </button>

    <!-- Готов к сборке -->
    <button 
      v-if="status.id == 700" 
      @click="putStatus(600)"
      class="btn btn-outline-success"
    >
      Готов к сборке
    </button>  


    <!-- Отменён -->
    <button 
      v-if="status.id != 0 && status.id != 600"
      @click="putStatus(0)"
      class="btn btn-outline-danger"
    >
      Отменён
    </button>

    <span v-if="status.id == 600" style="font-size: 3.3em;">
      🦆
    </span>

  </div>
  
  <!-- Get Next -->
  <div style="display: flex;flex-direction: column;">
    <!-- Email -->
    <a 
      class="btn btn-sm btn-outline-info"
      :disabled="(toConfirm.email == undefined || toConfirm.email.length == 0)"      
      :style="(toConfirm.email == undefined || toConfirm.email.length) == 0 ? 'cursor: no-drop;' : ''"
      :href="(toConfirm.email != undefined && toConfirm.email.length > 0) ? '/confirm/'+toConfirm.email[0] : '#'"
    >
      Следующий 📧
      <span v-if="toConfirm.email != undefined" class="badge badge-primary">{{toConfirm.email.length}}</span>
    </a>
    <!-- Phone -->
    <a 
      class="btn btn-sm btn-outline-info"
      :disabled="(toConfirm.phone == undefined || toConfirm.phone.length == 0)"
      :style="(toConfirm.phone == undefined || toConfirm.phone.length) == 0 ? 'cursor: no-drop;' : ''"
      :href="(toConfirm.phone != undefined && toConfirm.phone.length > 0) ? '/confirm/'+toConfirm.phone[0] : '#'"
    >
      Следующий ☎️
      <span v-if="toConfirm.phone != undefined" class="badge badge-primary">{{toConfirm.phone.length}}</span>
    </a>
  </div>

</div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      order:'getOrder',
      status:'getOrderStatus',
      confirm:'getOrderConfirmType',
      toConfirm:'getToConfirm',
    }),
  },
  watch: {
    order: function(){
      this.fetchToConfirm(this.order.id);
    },
  },
  methods:{
    ...mapActions(['putStatus','fetchToConfirm']),
    orderDate(){
      return moment(this.status.pivot.created_at).format('DD.MM H:m');
    }    
  }
}
</script>

<style scoped>
  .confirm-actions button, .confirm-actions a{
    margin:5px;
  }
</style>