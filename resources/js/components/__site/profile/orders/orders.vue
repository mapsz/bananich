<template>
  <main>
    <div class="container">
      <!-- Breadcrumbs -->
      <breadcrumbs />
      <div class="row content-page">

        <!-- Navbar -->
        <div class="col-lg-4">            
          <profile-navbar></profile-navbar>
        </div>

        <div class="col-lg-8">

          <div class="title-wrap">
            <h2 class="title-h2 title-page">Мои заказы</h2>
          </div>
        
          <div class="content">
      
            <!-- Табы навигация -->
            <order-status-filter />

            <div class="tab-content">
              <div class="tab-pane fade show active" id="all">

                <!-- Order -->
                <div v-for='(order,i) in orders' :key='i' class="order-item">
                  <div class="order-wrap">

                    <div>
                      <div class="order-name"><a href="#" class="order-name-btn">{{fDate(order.created_at)}}</a></div> 
                      <div class="order-track">{{order.id}}</div> <!-- Класс active или cancellation у родителя order-item меняет оформление -->
                    </div>
                  
                    <div class="order-right">
                      <div class="order-status">
                        {{order.status}}
                      </div><!-- Класс active или cancellation у родителя order-item меняет оформление -->
                      <div class="d-flex">
                        <div class="order-values">
                          <div class="order-value-img"><img src="/image/order/card.svg" alt="Количестово"></div>
                          <div class="order-value-text">{{order.items.length}} шт</div>
                        </div>
                        <div class="order-values">
                          <div class="order-value-img"><img src="/image/order/money.svg" alt="Сумма"></div>
                          <div class="order-value-text">{{order.total}} руб   </div>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>


              </div>
              <div class="tab-pane fade" id="delivered"></div>              
            </div> 

          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    //
  }},
  computed:{
    ...mapGetters({orders:'order/get',user:'user/get'}), 
  },
  watch: {
    user: {
      handler: async function (val, oldVal) {
        if(this.user){
          await this.addFilter({customerId:this.user.id})
          await this.fetch();
        }
      },
      deep: true
    }
  },
  methods:{    
    ...mapActions({'addFilter':'order/addFilter','fetch':'order/fetchData'}),
    fDate(date){
      return moment(date).locale("ru").format('MMMM Do');
    }
  },
}





                  // <!-- Item -->
                  // <div class="order-item active">
                  //   <div class="order-wrap">
                  //     <div>
                  //       <div class="order-name"><a href="#" class="order-name-btn">Заказ 5 апреля</a></div>
                  //       <div class="order-track">TRK09845098</div> <!-- Класс active или cancellation у родителя order-item меняет оформление -->
                  //     </div>                
                  //     <div class="order-right">
                  //       <div class="order-status">В пути</div><!-- Класс active или cancellation у родителя order-item меняет оформление -->
                  //       <div class="d-flex">
                  //         <div class="order-values">
                  //           <div class="order-value-img"><img src="/image/order/card.svg" alt="Количестово"></div>
                  //           <div class="order-value-text">100 шт</div>
                  //         </div>
                  //         <div class="order-values">
                  //           <div class="order-value-img"><img src="/image/order/money.svg" alt="Сумма"></div>
                  //           <div class="order-value-text">2000 руб</div>
                  //         </div>
                  //       </div>
                  //     </div>
                  //   </div>
                  //   <div class="order-courier">
                  //     <div class="order-box d-flex align-sm-items-center">
                  //       <div class="order-courier-ava" style="background-image: url('image/order/courier-ava.png');"></div>
                  //       <div class="d-sm-flex align-items-center">
                  //         <div class="order-box-text mr-sm-3 mr-md-5"><span>Курьер</span> Иван Иванов</div>
                  //         <div class="order-box-text"><span>Доставка</span> с 15:30 до 18:30</div>
                  //       </div>
                  //     </div>
                  //     <div class="order-box">
                  //       <div class="order-box-text d-sm-block d-none"><span>Телефон</span> +7 (909) 777-77-77</div>
                  //       <a class="order-box-call d-sm-none" href="tel:+79097777777"><img src="/image/order/phone.svg" alt="Phone"></a>
                  //     </div>
                  //   </div>

                  //   <div class="order-info">
                  //     <div class="order-box order-box-flex">
                  //       <div class="d-flex align-items-center">
                  //         <div class="order-info-ico"><img src="/image/order/i.svg" alt="info"></div>
                  //         <div class="order-info-text">Отсутствует <a href="#!">Джем черничный 150р</a></div>
                  //       </div>
                  //       <div class="order-info-btn"><a href="#!" class="btn">Заменить</a></div>
                  //     </div>
                  //   </div>
                    
                  //   <!-- Строка работает по такому принципу: активному состоянию назначается класс is-active и выводится время, после того как статус меняется, is-active переходит к следующему состоянию, а текущее состояние получает класс is-achieved  -->
                  //   <div class="order-status-tracker">
                  //     <ul class="tracker">
                  //       <li class="tracker-status is-achieved"><span class="tracker-date"></span><span class="tracker-label"></span><span class="tracker-name">Собирается</span></li>
                  //       <li class="tracker-status is-achieved"><span class="tracker-date"></span><span class="tracker-label"></span><span class="tracker-name">Собран</span></li>
                  //       <li class="tracker-status is-active"><span class="tracker-date">14:07</span><span class="tracker-label"></span><span class="tracker-name">В пути</span></li>
                  //       <li class="tracker-status "><span class="tracker-date"></span><span class="tracker-label"></span><span class="tracker-name">Доставлен</span></li>
                  //     </ul>
                  //   </div>

                  // </div>

                  // <!-- Item -->
                  // <div class="order-item cancellation">
                  //   <div class="order-wrap">
                  //     <div>
                  //       <div class="order-name"><a href="#" class="order-name-btn">Заказ 5 апреля</a></div>
                  //       <div class="order-track">TRK09845098</div> <!-- Класс active или cancellation у родителя order-item меняет оформление -->
                  //     </div>

                  //     <div class="order-right">
                  //       <div class="order-status">Отменен</div><!-- Класс active или cancellation у родителя order-item меняет оформление -->
                  //       <div class="d-flex">
                  //         <div class="order-values">
                  //           <div class="order-value-img"><img src="/image/order/card.svg" alt="Количестово"></div>
                  //           <div class="order-value-text">100 шт</div>
                  //         </div>
                  //         <div class="order-values">
                  //           <div class="order-value-img"><img src="/image/order/money.svg" alt="Сумма"></div>
                  //           <div class="order-value-text">2000 руб</div>
                  //         </div>
                  //       </div>
                  //     </div>
                  //   </div>              
                  // </div>





</script>

<style>

</style>


