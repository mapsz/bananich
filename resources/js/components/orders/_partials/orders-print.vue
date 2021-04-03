<template>
  <div class="mx-3">
    <button @click="printModalOpen()" class="btn btn-primary">Print ({{getOrders.length}})</button>
    <!-- Input modal -->
    <div class="modal fade" id="print-modal" tabindex="-1">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Print</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">            
            <button @click="printElem()">print</button>
            <div class="print-place">
              <div 
                v-for="order in getOrders" 
                :key="order.id" 
                class="print-order"
                style="page-break-after: always;"
              >                
                <h2>Заказ №{{order.id}}</h2>
                <!-- Contact details -->
                <div style="padding: 10px 0px;display: flex;flex-direction: column;">
                  <div style="display: flex;justify-content: flex-end;">{{order.name}}</div>
                  <div style="display: flex;justify-content: flex-end;">{{order.address}} {{order.appartPorch}}</div>
                  <div style="display: flex;justify-content: flex-end;">{{order.phone}}</div>
                  <div style="display: flex;justify-content: flex-end;">{{order.delivery_date}}</div>
                </div>
                <hr>
                <!-- Table -->
                <div class="print-table" style=" display: flex; justify-content: center;">
                  <table  style="text-align: center; font-size: small;">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th :colspan="order.type != 'x' ? '' : '3'" scope="col">Наименование</th>
                        <th scope="col">Цена за кг\шт</th>
                        <th scope="col">Количество</th>
                        <th v-if="order.type != 'x'" scope="col">Цена без скидки</th>
                        <th v-if="order.type != 'x'" scope="col">Скидка</th>
                        <th scope="col">Цена</th>
                      </tr>                    
                    </thead>
                    <tbody>
                      <tr 
                        class="p-1 item-data"
                        v-show="item.quantity_result > 0" 
                        v-for="item in order.items" 
                        :key="item.id" 
                      >
                        <td >{{item.product_id}}</td>
                        <td :colspan="order.type != 'x' ? '' : '3'">{{item.name}}</td>
                        <td >{{r(item.price_one)}}</td>
                        <td >{{r3(item.quantity_result)}}</td>
                        <td v-if="order.type != 'x'">{{r(item.price_final_result) + (item.discount_final_result != undefined ? r(item.discount_final_result) : 0)}}</td>                      
                        <td v-if="order.type != 'x'">{{r(item.discount_final_result != undefined ? item.discount_final_result : 0)}}</td>                      
                        <td >{{r(item.price_final_result)}}</td>                      
                      </tr>
                    </tbody>
                    <tfoot class="checkout">
                      
                      <!-- Subtotal -->
                      <tr v-if="order.type == 'x'">
                        <td></td><td></td><td></td><td></td><td></td>
                        <th >Подытог:</th>
                        <td >{{r(order.items_subtotal_result)}}</td>
                      </tr>
                      <tr>
                        <td></td><td></td><td></td>
                        <!-- Subtotal -->
                        <th >{{order.type != 'x' ? 'Подытог:' : ''}}</th>
                        <td >{{order.type != 'x' ? r(order.items_subtotal_result) : ''}}</td>
                        <!-- Shipping -->
                        <template>
                          <th >Доставка:</th>
                          <td>
                            {{
                              order.type == 'x' 
                              ?   
                              (order.xData.personalAddress != undefined ? r(order.xData.personalAddress) : 0)    
                              : 
                              r(order.shipping)
                            }}                            
                          </td>
                        </template>
                      </tr>
                      <!-- Participation price -->
                      <tr v-if="order.type == 'x' && order.participation_price != undefined && order.participation_price != 0">
                        <td></td><td></td><td></td><td></td><td></td>
                        <th>Сервисный взнос:</th>
                        <td>{{r(order.participation_price)}}</td>
                      </tr>
                      <!-- Over weight -->
                      <tr v-if="order.type == 'x' && order.over_weight_price != undefined && order.over_weight_price != 0">
                        <td></td><td></td><td></td><td></td><td></td>
                        <th>Дополнительный вес:</th>
                        <td>{{r(order.over_weight_price)}}</td>
                      </tr>
                      <!-- Discounts -->
                      <tr v-if="order.discounts_total_result != 0">
                        <td></td><td></td><td></td><td></td><td></td>
                        <th>Скидки:</th>
                        <td>{{r(order.discounts_total_result)}}</td>
                      </tr>
                      <!-- Coupons -->
                      <tr v-if="order.coupons_total != 0">
                        <td></td><td></td><td></td><td></td><td></td>
                        <th>Купоны:</th>
                        <td>{{r(order.coupons_total)}}</td>
                      </tr>
                      <!-- Extra charges -->
                      <template v-if="order.extra_charges != undefined && order.extra_charges[0] != undefined">
                        <tr v-for="charges in order.extra_charges" :key="charges.id">
                          <td></td><td></td><td></td><td></td><td></td>
                          <th>{{charges.name}}:</th>
                          <td>{{parseInt(charges.value)}}</td>
                        </tr>
                      </template>
                      <!-- Bonus -->
                      <tr v-if="order.bonus != undefined && order.bonus != 0">
                        <td></td><td></td><td></td><td></td><td></td>
                        <th>Бонусы:</th>
                        <td>{{r(order.bonus)}}</td>
                      </tr>
                      <!-- Total -->
                      <tr>
                        <td></td><td></td><td></td><td></td><td></td>
                        <th>Итого:</th>
                        <td><b>{{r(order.total_result)}}</b></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

                
                <hr>

                <div v-if="order.type == 'x'" class="mx-1">
                  <div style="font-size:11pt">
                    <b>
                      Если вам понравился наш сервис, расскажите о нем в сторис Инстаграм, упомянув наш аккаунт @neolavka_spb. И получите к следующему заказу подарок на выбор:
                    </b>
                  </div>

                  <div class="mt-3" style="font-size:10pt">
                    <ul>
                      <li>50гр любого чая с сайта на выбор</li>
                      <li>100гр любого кофе на выбор</li>
                      <li>100гр манго цукат</li>
                      <li>200гр ореховой смеси</li>
                      <li>200гр чайной смеси</li>
                      <li>300гр шоколадных фиников</li>
                    </ul>
                  </div>

                  <div  style="font-size:10pt">
                    Чтобы получить подарок, в комментарии к заказу укажите ваш аккаунт в Инстаграмме и желаемый подарок.
                  </div>

                  <div  class="mt-3" style="font-size:10pt">
                    ПОЛУЧИТЕ 1000 рублей на покупки в NEOLAVKA.RU! Каждый месяц 25го числа подписчики наших аккаунтов выбирают самый полезный отзыв. Победителям в ВК и в Инстаграмме мы дарим по 1000 рублей на покупки в NEOLAVKA.RU
                  </div>
                </div>


              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>  

 


  </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  computed:{
    ...mapGetters({getOrders:'order/get'}),
  },
  methods:{
    printModalOpen(){
      $('#print-modal').modal('show');
    },
    printElem(){
      var mywindow = window.open('', 'PRINT', 'height=400,width=600');

      mywindow.document.write($('.print-place').html());

      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10*/

      mywindow.print();
      // mywindow.close();

      return true;
    },
    r($v){
      return Math.round($v);
    },
    r3($v){
      return Math.round($v * 10000) / 10000;
    }
  },
}
</script>

 <style scoped>


    .print-table thead th{
      padding:5px;
    }

    .print-table tbody td{
      padding:0px 5px;
    }

    .print-table tbody tr:last-child{
      border-bottom: 1px solid black;
    }

    
    

    @media print {
      .checkout{
        page-break-inside:avoid ;
      }
      .print-order {
        page-break-after: always;
      } 
    } 
  </style>