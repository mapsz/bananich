<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>

  <div class="container-fluid">    
    <h1> Выдача Заказ №{{id}}</h1>
    <div class="row">

      <!-- Shipping info -->
      <div class="col-12 col-md-4 p-0 delivery-wrap delivery-shipping-info">
        <div class="my-2 m-md-2 p-2 delivery-border">
          <h4>Детали Заказа</h4>
          <div>
            <div>{{order.name}}</div>
            <div>{{order.phone}}</div>
            <div>{{order.email}}</div>
            <div>
              <span>{{order.address}}</span>  
              <span v-if="order.appart">кв. {{order.appart}}</span>  
              <span v-if="order.porch">пд. {{order.porch}}</span>  
            </div>
            <div>{{order.delivery_date}}</div>
            <div>{{delivery_time}}</div>
            <div>{{order.confirm == 1 ? 'Потверждение по телефону' : 'Потверждение по почте'}}</div>
            <div v-if="order.comment">Комментарий клиент: {{order.comment}}</div>          
            <div v-if="order.comment_our">Комментарий бананыч: {{order.comment_our}}</div>
            <div>{{order.created_at}}</div>
          </div>                  
          <!-- Comments -->
          <user-comments :user-id="order.customer_id" class="my-2" />
        </div>
      </div>

      <!-- Items List -->
      <div class="col-12 col-md-4 p-0 delivery-wrap delivery-shipping-items">
        <div class="my-2 m-md-2 p-2 delivery-border">
          <h4>Список продуктов</h4>
          <div style="margin: 0px -0.5rem;">
            <delivery-items />
          </div>          
        </div>
      </div>

      <!-- Checkout / Actions -->
      <div class="col-12 col-md-4 p-0 delivery-wrap">

        <!-- Checkout -->
        <div class="my-2 m-md-2 p-2 delivery-border">
          <h4>Итоги</h4>
          <show-checkout :order="order" :show="'result'"></show-checkout>
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

          <!-- Deliver Buttons -->
          <div class="d-flex justify-content-between">
            <button 
              @click="setDelivered()" 
              v-if="order.statuses != undefined && !(order.statuses[0].id == 1 || order.statuses[0].id == 100)"
              class="btn btn-success"
            >
              Доставлен  
            </button>  
            <button 
              @click="setOrderReturned(order.id)" 
              v-if="order.statuses != undefined && !(order.statuses[0].id == 1 || order.statuses[0].id == 100)"
              class="btn btn-danger"
            >
              Возврат  
            </button>  
          </div> 

          <!-- Delivered Cancel -->
          <div style="display: flex;justify-content: space-between;">
            <!-- Delivered -->
            <span v-if="order.statuses != undefined && order.statuses[0].id == 1" class="text-success">
              Заказ Доставлен! {{order.statuses[0].pivot.created_at}}
            </span>
            <!-- Returned -->
            <span v-if="order.statuses != undefined && order.statuses[0].id == 100" class="text-danger">
              Заказ Возращен! {{order.statuses[0].pivot.created_at}}
            </span>
            <!-- Cancel -->
            <span v-if="order.statuses != undefined && (order.statuses[0].id == 1 || order.statuses[0].id == 100)">
              <button @click="deleteDelivery(order.id)" class="btn btn-outline-danger">Отменить</button>
            </span>
          </div>

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
  ...mapGetters({order:'order/getOne'}),
  delivery_time:function(){
    if(this.order.delivery_time_from == undefined || this.order.delivery_time_from == undefined) return "";
    return this.order.delivery_time_from.slice(0,2)+ ' - ' +this.order.delivery_time_to.slice(0,2)
  },
},
mounted(){
  this.fetchOrder(this.id);
},
methods:{
  ...mapActions({'fetchOrder':'order/fetchOne',deleteDelivery:'deleteDelivery',setOrderReturned:'order/setReturned',}),
  async setDelivered(){
    
    {//Validate Pays
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
        if(this.payMethod.sum != this.order.total_result){
          this.errors.push('Суммы не совпадают!');
          return
        }
      }
    }

    //fetch
    let r = await ax.fetch('/put/delivery',
      {
        orderId:this.id,
        items:this.order.items,
        payMethod:this.payMethod,
        sum:this.order.total_result,  
      },
      'put'
    );
    
    if(!r) return;    

    //update available
    ax.fetch('/order/update/available', {id:this.id});

    location.reload();
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