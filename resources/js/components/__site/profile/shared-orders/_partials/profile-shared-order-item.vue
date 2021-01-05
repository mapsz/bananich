<template>
  <div class="order-item">

    <!-- Date / ID / Status / Cart count / Cart summ-->
    <div v-if="sOrder" class="">

      <!-- ID / Status -->
      <div class="d-flex justify-content-between w-100 mb-3 cancellation">
        <div class="order-track">
          {{sOrder.id}}
        </div>
        
        <div class="order-status m-0">
          {{sOrder.status.name}}
        </div>
      </div>

      <!-- Delivery Date Time -->
      <div class="d-flex justify-content-between w-100 mb-3">
        <div class="sad-order-value-text m-0" style="font-weight: 400;">Доставка:</div>
        <div class="d-flex justify-content-end">
          <div class="sad-order-value-text mr-3">{{moment(sOrder.delivery_date).locale("ru").format('MMMM D')}}</div>
          <div class="sad-order-value-text">
            {{moment(sOrder.delivery_time_from, 'HH:mm:ss').format('HH:mm')}} - 
            {{moment(sOrder.delivery_time_to, 'HH:mm:ss').format('HH:mm')}}
          </div>
        </div>
      </div>

      <!-- Owner / Member count -->
      <div class="d-flex justify-content-between w-100 mb-3 cancellation">
        <div class="sad-order-value-text m-0" style="font-weight: 400;">
          <span v-if="owner">Организатор: <b>{{owner.name}}</b></span> 
        </div>
        
        <div class="sad-order-value-text m-0" style="font-weight: 400;">
          Количество участников: <b>{{sOrder.member_count}}</b>
        </div>
      </div>

      <div class="d-flex justify-content-end">
        <a class="change" :href="'/shared/order/'+sOrder.link">изминить</a>
      </div>

    </div>
  </div>
</template>

<script>
export default {
props: ['s-order'],
data(){return{  
  moment:moment,
}},
computed:{
  owner(){
    if(!this.sOrder) return false;
    if(this.sOrder.owner_id == undefined) return false;

    return this.sOrder.users.find(x => x.id == this.sOrder.owner_id);

  },
},
}
</script>

<style scoped>

  .change{
    color: black;
    font-size: 16pt;
    text-decoration: underline;
  }

  .order-item{
    background: #e7dfdc!important;
  }

  .order-status{
    background-color: transparent;
    border: gray 1px solid;
    color: black;
  }

  .order-items-item{
    border-bottom: 1px solid #bdbdbd;
  }

  .order-items-checkout-title{
    font-size: 14pt;
    font-weight: 700;
    border-bottom: 1px solid #bdbdbd;
    padding-bottom: 10px;
  }

  .order-items-data{  
    display: flex;
    flex-direction: column;
    /* align-items: center; */
  }

  .order-checkout-data{
    display: flex;
    flex-direction: column;
    /* text-align: center; */
  }

  .order-track{
    padding: 0px 15px !important;
    font-weight: 700;
    color:black;
  }

  .sad-order-value-text{
    font-size: 16pt;
    font-weight: 600;
    margin-left: 8px;
  }

  @media (max-width: 768px){
    .sad-order-value-text{
      font-size: 10pt !important;
      margin-left: 4px;
    }
    .dropdown-sad-btn:after {
      right: -12px !important;
    }
    .dropdown-sad-btn{
      font-size: 12pt !important;
    }
  }

  .courier-align{
    display: flex !important;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }


</style>