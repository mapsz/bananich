<template>
<div>
  <!-- No items -->
  <template v-if="items < 1">      
    <div class="x-cart-do-button">
      <a href="/">                    
        <button class="x-btn">Начать собирать заказ</button>                    
      </a>
    </div>
  </template>

  <!-- Is items -->
  <template v-else>
    <!-- Open -->
    <template v-if="open">
      <!-- Confirmn -->
      <template v-if="confirm">
        <div class="shared-order-confirmed">
          <span class="shared-order-confirmed-check">✔️</span>
          <span>
            <div class="shared-order-confirmed-success">Ваш заказ оформлен.</div>
            Вы можете внести изменения в корзину до
            {{moment(myOrder.order_close).locale("ru").format('LLL')}}
          </span>
        </div>   
      </template>
      <!-- Not confirm -->
      <template v-else>
          <div class="x-cart-do-button">
            <a :href="'/shared/order/'+link+'#confirm'">                    
              <button class="x-btn" style="">Завершить оформление заказа</button>                    
            </a>
          </div>
      </template>
    </template>

    <!-- Not Open -->
    <template v-else>
      <!-- Solo -->
      <div class="x-cart-do-button">
        <a href="/checkout">
          <button class="x-btn" style="padding:0 9px; margin: 0 -10px;">👤 Оформить индивидуальный заказ</button>
        </a>
        <div v-if="settings && settings.x_order_price != undefined && settings.x_order_price > 0">
          Сервисный сбор {{settings.x_order_price}}p.
        </div>
      </div>
      
      <!-- Or -->
      <div class="x-or my-3">
        <span class="x-or-line"><hr></span>
        <span class="x-or-or">ИЛИ</span>
        <span class="x-or-line"><hr></span>
      </div>

      <!-- Group -->
      <template>
        <template v-if="!invited">
          <div class="x-cart-do-button">
            <a href="/shared/order">                    
              <button class="x-btn" style="padding:0 10px; margin: 0 -10px;">👥 Оформить коллективную закупку</button>                    
            </a>
          </div>
        </template>
        <template v-else>
          <div class="x-cart-do-button">
            <a :href="'/shared/order/'+invite">                    
              <button class="x-btn" style="">👥 Присоединиться к закупке</button>                    
            </a>
          </div>
        </template>
      </template>
    </template>





    <template  v-if="0">
      <div>
        
      </div>
    

      <!-- no Order -->
      <template v-if="1">
        <div class="x-cart-do-button">
          <a href="/checkout">
            <button class="x-btn" style="padding:0 9px; margin: 0 -10px;">👤 Оформить индивидуальный заказ</button>
          </a>
          <div v-if="settings && settings.x_order_price != undefined && settings.x_order_price > 0">
            Сервисный сбор {{settings.x_order_price}}p.
          </div>
        </div>

        <div class="x-or my-3">
          <span class="x-or-line"><hr></span>
          <span class="x-or-or">ИЛИ</span>
          <span class="x-or-line"><hr></span>
        </div>


      </template>    
      <!-- is Order -->
      <template v-else>
        <template v-if="confirm">
          <div class="shared-order-confirmed">
            <span class="shared-order-confirmed-check">✔️</span>
            <span>
              <span class="shared-order-confirmed-success">Ваш заказ оформлен.</span>
              Вы можете внести изменения в корзину до
              {{moment(myOrder.order_close).locale("ru").format('LLL')}}
            </span>
          </div>                          
        </template>
        <template v-else>
          <button @click="goToOrder()" class="x-btn">
            Оформить
          </button>
        </template>
      </template>

    </template>


  </template>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    halloween:halloween,isX:isX,
    moment:moment,
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      settings:'settings/beautyGet',
      user:'user/get',
      myOrder:    'sharedOrder/getMyOrder',
      inviteOrder:'sharedOrder/getInviteOrder',
    }),
    confirm(){
      if(this.user == undefined && !this.user) return false;
      if(!this.myOrder || this.myOrder.orders == undefined || this.myOrder.orders.length <= 0) return false;

      let order = this.myOrder.orders.find(x => x.customer_id == this.user.id);
      if(!order || order.x_confirm == undefined) return false
      return order.x_confirm;    
    },
    items: function(){
      if(this.cart == undefined || !this.cart || this.cart.items  == undefined) return false;
      return this.cart.items.length;
    },
    open:function (){
      if(this.myOrder == undefined || !this.myOrder || this.myOrder.open  == undefined) return false;
      return this.myOrder.open;
    },
    invite(){
      return Cookies.get('x_invite');
    },
    invited:function(){
      if(
        (this.invite != undefined && this.invite) &&       
        (this.inviteOrder != undefined && this.inviteOrder.joinable) && 
        (!this.myOrder || this.myOrder.length == 0)
      ){
        return true;
      }

      return false;
    },
    link(){
      if(!this.myOrder || this.myOrder.link == undefined || !this.myOrder.link) return false;
      return this.myOrder.link;
    },    
  }
}
</script>

<style>

</style>