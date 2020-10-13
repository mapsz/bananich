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
                        <th scope="col">Наименование</th>
                        <th scope="col">Цена за кг\шт</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Цена без скидки</th>
                        <th scope="col">Скидка</th>
                        <th scope="col">Цена</th>
                        <!-- <th scope="col">Time</th>
                        <th scope="col">Status</th> -->
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
                        <td >{{item.name}}</td>
                        <td >{{r(item.price_one)}}</td>
                        <td >{{r3(item.quantity_result)}}</td>
                        <td >{{r(item.price_result)}}</td>                      
                        <td >{{r(item.discount_final_result != undefined ? item.discount_final_result : 0)}}</td>                      
                        <td >{{r(item.price_final_result)}}</td>                      
                      </tr>
                    </tbody>
                    <tfoot class="checkout">
                      <tr>
                        <td></td><td></td><td></td>
                        <!-- Subtotal -->
                        <th>Подытог:</th>
                        <td>{{r(order.items_subtotal_result)}}</td>
                        <!-- Shipping -->
                        <th>Доставка:</th>
                        <td>{{r(order.shipping)}}</td>
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
                      <!-- Bonus -->
                      <tr>
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
      return Math.round($v * 1000) / 1000;
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