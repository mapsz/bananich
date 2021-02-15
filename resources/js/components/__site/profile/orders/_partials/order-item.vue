<template>
  <div v-if="order != undefined && order.id != undefined" class="order-item">

    <!-- Date / ID / Status / Cart count / Cart summ-->
    <div class="">

      <!-- ID / Status -->
      <div class="d-flex justify-content-between w-100 mb-3 cancellation">
        <div class="order-track">
        <!-- <div> -->
          {{order.id}}
        </div>
        
        <div v-if="order != undefined && order.statuses != undefined && order.statuses[0] != undefined" class="order-status m-0" 
          :style="
            //Red
            (order.statuses[0].id == 0 || order.statuses[0].id == 100 || order.statuses[0].id == 150 ? 'color:#EB5757;' : '') + 
            //Orange
            (order.statuses[0].id == 850 ? 'color:#fc8e50;' : '') + 
            //Green
            (order.statuses[0].id == 1 ? 'color:#0aa62e;' : '')
          "
        >
        <!-- <div> -->
          {{order.status}}
        </div>
      </div>

      <!-- Shared order -->
      <div v-if="sOrder" class="mb-2">
        <span class="sad-order-value-text m-0" style="font-weight: 400;">
          Закупка <a :href="'/shared/order/'+sOrder.link" style="color: black; text-decoration: underline;">№{{sOrder.id}}</a> 
        </span>
        

      </div>

      <!-- Delivery Date Time -->
      <div v-if="order.logistics == undefined || order.logistics[0] == undefined" class="d-flex justify-content-between w-100 mb-3">
        <div class="sad-order-value-text m-0" style="font-weight: 400;">Доставка:</div>
        <div class="d-flex justify-content-end">
          <div class="sad-order-value-text mr-3">{{moment(order.delivery_date).locale("ru").format('MMMM D')}}</div>
          <div class="sad-order-value-text">
            {{moment(order.delivery_time_from, 'HH:mm:ss').format('HH:mm')}} - 
            {{moment(order.delivery_time_to, 'HH:mm:ss').format('HH:mm')}}
          </div>
        </div>
      </div>

      <!-- Logistic -->
      <div v-if="order.logistics != undefined && order.logistics[0] != undefined" class="order-courier m-0 p-4">
        
        <!-- Courier photo -->
        <div v-if="order.logistics[0].driver" class="order-courier-ava" :style="`background-image: url('`+order.logistics[0].driver.mainPhoto+`');`"></div>

        <div class="d-sm-flex">
          <!-- Driver -->
          <div v-if="order.logistics[0].driver" class="order-box-text mr-sm-3 mr-md-5 courier-align">
            <span>Курьер</span> 
            {{order.logistics[0].driver.name}} {{order.logistics[0].driver.surname}} 
          </div> 

          <!-- Delivery -->
          <div class="order-box-text mt-2 courier-align"><span>Доставка</span>
              <div class="mb-1">{{moment(order.delivery_date).locale("ru").format('MMMM D')}}</div>
              <div>
                с {{moment(order.logistics[0].plan_arrival_time,"HH:mm:ss").subtract(40,'minutes').format('HH:mm')}}
                до {{moment(order.logistics[0].plan_arrival_time,"HH:mm:ss").add(40,'minutes').format('HH:mm')}}
              </div>
          </div>
        </div>

        <!-- Phone -->
        <div v-if="order.logistics[0].driver" class="order-box">
          <div class="order-box-text d-sm-block d-none">
            <div class="courier-align">
              <span>Телефон</span> 
              <div>{{order.logistics[0].driver.phone}} </div> 
            </div>
          </div>
          <a class="order-box-call d-sm-none" :href="'tel:'+order.logistics[0].driver.phone"><img src="/image/phone.svg" alt="Phone"></a>
        </div>

        <!-- <div class="order-box d-flex align-sm-items-center"> -->

          <!-- <div v-if="order.logistics[0].driver" class="order-courier-ava" :style="`background-image: url('`+order.logistics[0].driver.mainPhoto+`');`"></div> -->

          <!-- <div class="d-sm-flex align-items-center"> -->
            
            <!-- Driver -->
            <!-- <div v-if="order.logistics[0].driver" class="order-box-text mr-sm-3 mr-md-5">
              <span>Курьер</span> 
              {{order.logistics[0].driver.name}} {{order.logistics[0].driver.surname}} 
            </div> -->

            <!-- Delivery -->
            <!-- <div class="order-box-text mt-2"><span>Доставка</span>
              <div>
                <div class="mb-1">{{moment(order.delivery_date).locale("ru").format('MMMM D')}}</div>
                <div>
                  с {{moment(order.logistics[0].plan_arrival_time,"HH:mm:ss").subtract(40,'minutes').format('HH:mm')}}
                  до {{moment(order.logistics[0].plan_arrival_time,"HH:mm:ss").add(40,'minutes').format('HH:mm')}}
                </div>
              </div>
            </div> -->
          <!-- </div> -->
        <!-- </div> -->

        <!-- <div v-if="order.logistics[0].driver" class="order-box">
          <div class="order-box-text d-sm-block d-none"><span>Телефон</span> {{order.logistics[0].driver.phone}} </div>
          <a class="order-box-call d-sm-none" :href="'tel:'+order.logistics[0].driver.phone"><img src="/image/phone.svg" alt="Phone"></a>
        </div> -->

      </div>    

      <!-- Order date / Cart count / Cart summ -->
      <div class="d-flex justify-content-between w-100 mt-3">

        <!-- Order date -->
        <div class="d-flex align-self-center">
          <div class="sad-order-value-text dropdown-sad-item m-0" :class="showMore ? 'active' : ''">
            <a href="#" @click.prevent="showMore = !showMore" class="dropdown-sad-btn">Подробней</a>
            <!-- <a href="#" @click.prevent="showMore = !showMore" class="dropdown-sad-btn">{{moment(order.created_at).locale("ru").format('MMMM D')}}</a> -->
          </div>          
        </div>

        <!-- Cart count / Cart summ -->
        <div class="d-flex justify-content-end">
          <!-- Cart count -->
          <div class="order-values">
            <div class="order-value-img"><img src="/image/order/card.svg" alt="Количестово"></div>
            <div class="sad-order-value-text">{{order.items.length}} шт</div>
          </div>
          <!-- Cart summ -->
          <div class="order-values">
            <div class="order-value-img" style="position:relative;">
              <span class="cur-ru">₽</span>
            </div>
            <div class="sad-order-value-text">
              {{(order.total_result == undefined || !(order.total_result > 0)) ? order.total : order.total_result}} руб
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- Status history -->
    <div v-if="showMore" class="order-status-tracker p-0">
      <!-- 
        Строка работает по такому принципу: активному состоянию назначается класс is-active и выводится время, после того как статус меняется, is-active переходит к следующему состоянию, а текущее состояние получает класс is-achieved  
      -->
      <!-- <ul class="tracker">
        <li class="tracker-status is-achieved"><span class="tracker-date"></span><span class="tracker-label"></span><span class="tracker-name">Оформлен</span></li>
        <li class="tracker-status is-achieved"><span class="tracker-date"></span><span class="tracker-label"></span><span class="tracker-name">Собирается</span></li>
        <li class="tracker-status is-achieved"><span class="tracker-date"></span><span class="tracker-label"></span><span class="tracker-name">Собран</span></li>
        <li class="tracker-status is-active"><span class="tracker-date">14:07</span><span class="tracker-label"></span><span class="tracker-name">В пути</span></li>
        <li class="tracker-status "><span class="tracker-date"></span><span class="tracker-label"></span><span class="tracker-name">Доставлен</span></li>
      </ul> -->
    </div>   

    <!-- Items / Checkout    -->
    <div v-if="showMore" class="order-items-checkout mt-3">

      <!-- Title -->
      <div class="order-items-checkout-title">О заказе</div>

      <!-- Item rows -->
      <div v-for='(item,i) in order.items' :key='i' class="row order-items-item py-2 mx-2"> 

        <!-- Name -->
        <div class="col-12 col-md-4 col-xl-6 p-0 align-self-center font-weight-bold">
          <a :href="'/product/'+item.product_id" style="color:black">{{item.name}}</a>          
        </div>

        <!-- Pre Data-->
        <div class="col-6 col-md-4 col-xl-3 order-items-data">
          <div>При заказе:</div>
          <div>
            <!-- Quantity -->
            <span>
              {{Math.round(item.gram_sys * item.quantity  * 10000) / 10000}}
            </span>
            /
            <!-- Price -->
            <span>
              {{item.price_final}}
            </span>
          </div>
        </div>        
        
        <!-- Result Data-->
        <div v-if="item.price_final_result != undefined" class="col-6 col-md-4 col-xl-3 order-items-data" style="font-weight: 600;">
          <div>Итого:</div>
          <div>
            <!-- Quantity -->
            <span>
              {{item.quantity_result}}
            </span>
            /
            <!-- Price -->
            <span>
              {{item.price_final_result}}
            </span>
          </div>
        </div> 

      </div>
    
      <!-- Checkout -->
      <div class="row mx-2">

        <!-- Pre -->
        <div class="col-6 col-md-4 offset-md-4 col-xl-3 offset-xl-6 order-checkout-data">
          <!-- Subtotal -->
          <div v-if="order.items_total != order.total">Подытог: {{order.items_total}}</div>
        </div>

        <!-- Result -->
        <div class="col-6 col-md-4 col-xl-3 order-checkout-data" v-if="order.total_result != undefined && order.total_result > 0">
          <!-- Subtotal -->
          <div v-if="order.items_total_result != order.total_result">Подытог: {{order.items_total_result}}</div>
        </div>

        <!-- Both -->
        <div class="col-12 col-md-8 offset-md-4 col-xl-6 offset-xl-6 order-checkout-data px-1 px-md-3">
          <!-- Delivery -->
          <div v-if="order.shipping != 0">Доставка: {{order.shipping}}</div>
          <!-- Bonus -->
          <div v-if="order.bonus != 0">Бонусы: {{order.bonus}}</div>
          <!-- Coupon -->
          <div v-if="coupon">{{coupon.code}}: {{coupon.discount}}</div>
          <!-- Participation -->
          <div v-if="isX">Сервисный взнос: {{order.xData.participation_price}}</div>
        </div>

        <!-- Pre -->
        <div class="col-6 col-md-4 offset-md-4 col-xl-3 offset-xl-6 order-checkout-data">
          <!-- Total -->
          <div style="font-weight: 600;">Всего: {{order.total}}</div>
        </div>

        <!-- Result -->
        <div class="col-6 col-md-4 col-xl-3 order-checkout-data" v-if="order.total_result != undefined && order.total_result > 0">
          <!-- Total -->
          <div style="font-weight: 600;">Всего: {{order.total_result}}</div>
        </div>
      </div>

    </div>
            
  </div>  
</template>

<script>
export default {
props: ['order'],
data(){return{  
  isX:isX,
  moment:moment,
  showMore:false,
}},
computed:{
  coupon: function(){
    if(this.order.coupons == undefined) return false;
    if(this.order.coupons[0] == undefined) return false;
    if(this.order.coupons[0].discount == 0) return false;

    let discount = this.order.coupons[0].discount;
    discount = discount > 0 ? discount - (discount*2) : discount;

    return {
      code:       this.order.coupons[0].code,
      discount:   discount
    }
  },
  sOrder(){
    if(this.order == undefined || this.order.shared_order == undefined || this.order.shared_order.length < 0) return false;
    return this.order.shared_order[0];
  }
},
}

{

      // <!-- Date / ID -->
      // <div class="">
      //   <!-- Date -->
      //   <div class="order-name dropdown-sad-item" :class="showMore ? 'active' : ''">
      //     <a href="#" @click.prevent="showMore = !showMore" class="dropdown-sad-btn">{{moment(order.created_at).locale("ru").format('MMMM D')}}</a>
      //   </div> 
      //   <!-- ID -->
      //   <div class="order-track">{{order.id}}</div> <!-- Класс active или cancellation у родителя order-item меняет оформление -->
      // </div>   

      // <div class="row">
      //   <div class="aaa">asd</div>
      //   <div class="aaa">dsa</div>
      //   <div class="aaa">zxc</div>
      // </div>

      // <!-- Status / Cart count / Cart summ -->
      // <div class="order-right">
      //   <!-- Status -->
      //   <div class="order-status">
      //     <!-- 
      //       Класс active или cancellation у родителя order-item меняет оформление 
      //     -->
      //     {{order.status}}
      //   </div>
      //   <!-- Cart count / Cart summ -->
      //   <div class="d-flex">
      //     <!-- Cart count -->
      //     <div class="order-values">
      //       <div class="order-value-img"><img src="/image/order/card.svg" alt="Количестово"></div>
      //       <div class="order-value-text">{{order.items.length}} шт</div>
      //     </div>
      //     <!-- Cart summ -->
      //     <div class="order-values">
      //       <div class="order-value-img"><img src="/image/order/money.svg" alt="Сумма"></div>
      //       <div class="order-value-text">
      //         {{(order.total_result == undefined || !(order.total_result > 0)) ? order.total : order.total_result}} руб
      //       </div>
      //     </div>
      //   </div>
      // </div> 

}
</script>

<style scoped>

  .order-status{
    background: #e0e0e0!important;
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

  .order-value-img cur-ru{
    font-size: 40px;
    position: absolute;
    top: -11px;
    left: 10px;
  }

  @media (max-width: 768px){
    
    .order-value-img cur-ru{
      font-size: 30px;
      position: absolute;
      top: -11px;
      left: 7px;
    }
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

