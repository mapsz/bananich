<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>

  <div class="container-fluid">    
    <h1>Заказ №{{id}}</h1>
    <div class="row">
      <!-- Shipping info -->
      <div class="col-12 col-md-4 p-0 delivery-wrap delivery-shipping-info">
        <div class="my-2 m-md-2 p-2 delivery-border">
          <h4>Детали Заказа</h4>
          <div>
            <div>{{getOrder.name}}</div>
            <div>{{getOrder.phone}}</div>
            <div>{{getOrder.email}}</div>
            <div>
              <span>{{getOrder.address}}</span>  
              <span v-if="getOrder.appart">кв. {{getOrder.appart}}</span>  
              <span v-if="getOrder.porch">пд. {{getOrder.porch}}</span>  
            </div>
            <div>{{getOrder.delivery_date}}</div>
            <div>{{delivery_time}}</div>
            <div>{{getOrder.confirm == 1 ? 'Потверждение по телефону' : 'Потверждение по почте'}}</div>
            <div v-if="getOrder.comment">Комментарий клиент: {{getOrder.comment}}</div>          
            <div v-if="getOrder.comment_our">Комментарий бананыч: {{getOrder.comment_our}}</div>
            <div>{{getOrder.created_at}}</div>
          </div>
        </div>
      </div>

      <!-- Items List -->
      <div class="col-12 col-md-4 p-0 delivery-wrap delivery-shipping-items">
        <div class="my-2 m-md-2 p-2 delivery-border">
          <h4>Список продуктов</h4>
          <div style="margin: 0px -0.5rem;">
            <delivery-items 
              @returnSuccess="get()" 
              :items="getOrder.items" 
              :edit="getOrder.statuses != undefined ? (getOrder.statuses[0].id == 1 ? false : true) : false"
            ></delivery-items>
          </div>          
        </div>
      </div>

      <!-- Checkout / Actions -->
      <div class="col-12 col-md-4 p-0 delivery-wrap">
        <!-- Checkout -->
        <div class="my-2 m-md-2 p-2 delivery-border">
          <h4>Итоги</h4>
          <show-checkout :order="getOrder" :show="'result'"></show-checkout>
        </div>   
        <!-- Pay Method -->
        <div class="my-2 m-md-2 p-2 delivery-border">
          <h4>Способ оплаты</h4>
          <delivery-pay-method v-model="payMethod"></delivery-pay-method>
        </div>  

        <!-- Actions -->
        <div class="my-2 m-md-2 p-2 delivery-border">

          <!-- Error -->
          <div class="errors text-danger">
            <ul>
              <li v-for='(error,i) in errors' :key='i'>
                {{error}}
              </li>
            </ul>

          </div>

          <!-- Deliver Button -->
          <button 
            @click="setDelivered()" 
            v-if="getOrder.statuses != undefined && getOrder.statuses[0].id != 1" 
            class="btn btn-success"
          >
            Доставлен  
          </button>   
          <!-- Deliver Show -->
          <span v-if="getOrder.statuses != undefined && getOrder.statuses[0].id == 1" class="text-success">
            Заказ Доставлен! {{getOrder.statuses[0].pivot.created_at}}
          </span>
        </div>  


      </div>




    </div>    
  </div>
  
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  id:this.$route.params.id,
  payMethod:false,
  errors:[],
}},
computed:{
  ...mapGetters(['getOrder']),
  delivery_time:function(){
    if(this.getOrder.delivery_time_from == undefined || this.getOrder.delivery_time_from == undefined) return "";
    return this.getOrder.delivery_time_from.slice(0,2)+ ' - ' +this.getOrder.delivery_time_to.slice(0,2)
  },
},
mounted(){
  this.fetchOrder(this.id);
},
methods:{
  ...mapActions(['fetchOrder']),
  async setDelivered(){
    //Validate Pays
    this.errors = [];
    if(!this.payMethod){
      this.errors.push('Выберите метод оплаты!');
      return;
    }
    if(this.payMethod == -3){
      this.errors.push('Укажите суммы оплаты!');
      return;      
    }
    if(this.payMethod.sum != undefined){
      if(this.payMethod.sum != this.getOrder.total_result){
        this.errors.push('Суммы не совпадают!');
        return
      }
    }


    let r = await this.jugeAx('/put/delivery',
      {
        orderId:this.id,
        items:this.getOrder.items,
        payMethod:this.payMethod,
        sum:this.getOrder.total_result,  
      },
      'put'
    );
    if(!r) return;
    this.fetchOrder(this.id);
  }
},
}
</script>

<style>
.delivery-border{
  border: 1px solid black;
  border-radius: 7px;
}
.may-method-item {
    margin: 5px 0;
}
</style>