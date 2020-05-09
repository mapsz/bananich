<template>
<div 
  v-if="status.name != undefined"
  class="d-flex justify-content-around border-top border-bottom p-3"
>
  <span class="align-self-center">
    {{orderDate()}} <b>{{status.name}}</b>    
  </span>
  <!-- Отменён -->
  <button 
    v-if="status.id != 0"
    @click="putStatus(0)"
    class="btn btn-outline-danger"
  >
    Отменён
  </button>

  <!-- Не поднимает трубку -->
  <button 
    v-if="
      confirm == 1 && 
      (
        status.id == 900 || 
        status.id == 850
      )" 
    @click="putStatus(850)"
    class="btn btn-outline-secondary"
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
    @click="putStatus(800)"
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
</div>

<!-- 
  0   - Отменен
  600 - Готов к сборке
  700 - Потверждён
  800 - Потверждён по телефону
  850 - Не поднимает трубку
  900 - оформлен
-->

</template>

<script>
export default {
  props: ['pOrderId'],
  data(){
    return {
      status:{},
      confirm:-1,
    }
  },
  mounted(){
    this.getOrder();
  },  
  methods:{
    async putStatus(status){
      let r = await this.jugeAx('/order/status',{orderId:this.pOrderId,statusId:status},'put');
      if(!r) {return}
      this.status = r;
    },
    async getOrder(){
      let r = await this.jugeAx('/json/orders',{id:this.pOrderId});
      if(!r) {return}
      this.status = r.statuses[0];
      this.confirm = r.confirm;
    },
    orderDate(){
      return moment(this.status.pivot.created_at).format('DD.MM H:m');
    }
  }
}
</script>

<style>

</style>