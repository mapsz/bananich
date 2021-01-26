<template>
  <div>
    <juge-main>
    
      <div class="container my-3">

        <!-- Header -->
        <div v-if="sOrder" class="my-5">
          <h1>Закупка №{{sOrder.id}}</h1>
        </div>        

        <!-- Congratz -->
        <template v-if="isAdmin && moment().unix() - moment(this.sOrder.created_at).unix() < 120 && !confirm">
          <!-- Congratz -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="congratz">
                Поздравляем, ваша совместная закупка открыта!
              </div>
            </div>
          </div>

          <!-- top text -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="top-text">
                Теперь можно пригласить в нее соседей или друзей!
              </div>
            </div>
          </div>
        </template>
        
        <!-- Invite -->
        <div v-if="isAdmin && !isFull && isOpen" class="row">
          <!-- Button -->
          <div class="col-12 col-lg-3 p-0 mt-lg-3 d-flex justify-content-center justify-content-lg-start ">                
            <button @click="copyInviteLink()" class="button x-btn">
              Пригласить в закупку соседей
            </button>
          </div>
          <!-- Copied -->
          <div class="col-12 col-lg-3 mt-lg-3" style="color: #eb5757;">
            <div v-if="copied">
              Ссылка на закупку скопирована в буфер обмена, теперь вы можете поделиться ей с друзьями
            </div>              
          </div>
          <!-- Soc. buttons -->
          <div class="col-12 col-lg-6 mt-4">
            Поделиться:
            <div class="invite-link my-2" style="font-size: 9pt;">
              https://neolavka.ru/shared/order/{{link}}
            </div>
            <div>
                <telegram-button
                  :shareUrl="shareLink"
                  :description="shareDescription"
                />
                <whatsapp-button
                  :shareUrl="shareLink"
                  :description="shareDescription"
                />
                <vkontakte-button
                  :shareUrl="shareLink"
                  :description="shareDescription"
                />
            </div>
          </div>

          <div class="col-12">              
            <hr class="my-5">
          </div>

        </div>

        <!-- Announce/Sould do -->
        <div  class="row" style="mb-5">
          <!-- Announce -->
          <div class="col-12 col-lg-6">
            <div  v-if="isAdmin && editable" class="announce-block">
              <div class="mb-3"><b>Вы можете менять дату, время и адрес закупки только до момента присоединения к ней другого участника.</b></div>  
              <div>После этого вы сможете вносить изменения только в свою корзину до 21.00 дня накануне доставки.</div>  
            </div>
          </div>
          <!-- Sould do -->
          <div v-if="0" class="col-12 col-lg-6 d-flex justify-content-center  justify-content-lg-start" style="display: flex !important;align-items: flex-end;">
            <button @click="goToGallery()" class="button x-btn">
              Начать собирать заказ
            </button>
          </div>
        </div>

        <!-- Close -->
        <div v-if="sOrder && untilClose" class="row my-5">
          <div class="col-12">

            <div v-if="sOrder.status_id == 0">
              Закупка отменена
            </div>

            <div v-else-if="sOrder.status_id > 200 || sOrder.status_id == 1">
              Закупка состоялась
            </div>


            <div v-else class="shared-order-timer-container">
              <div class="p-3">
                <div class="row">
                  <div class="col-12 col-lg-4">
                    <div class="announce-block mb-3">
                      <div class="shared-order-timer">
                        {{('0'+(untilClose/60/60).toFixed(0)).slice(-2)}} :
                        {{('0'+((untilClose/60)%60).toFixed(0)).slice(-2)}} :
                        {{('0'+((untilClose)%60).toFixed(0)).slice(-2)}} 
                      </div>
                      <div class="shared-order-timer-text">
                        время до окончания оформления заказа
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-8" style="display: flex;align-items: center;">
                    <div class="shared-order-timer-description">
                      Участники, не успевшие завершить оформление заказа до 21.00 дня накануне доставки, 
                      <b>автоматически исключаются из закупки</b>
                    </div>                
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>

        <!-- Test time -->
        <div v-if="0" class="row my-5">
          <div class="col-12">
            <!-- Test time -->
            <div v-if="sOrder.status != undefined" class="border p-2" style="background-color: #fb00ff40;">
              <h5>Test time</h5>
              <div><b>now:  </b>{{moment().locale("ru").format('LLL')}}</div>
              <div><b>fake: </b>{{moment(sOrder.test_time).locale("ru").format('LLL')}}</div>
              <div class="">
                <div>
                  <label for="t-h">Hours: </label><input v-model="test.hours"  type="number" name="hour" id="t-h" style="width:40px">
                </div>
                <div>
                  <label for="t-m" class="ml-2">Minutes: </label><input v-model="test.minutes"  type="number" name="minute" id="t-m"  style="width:40px">
                </div>
                <div>  
                  <button class="btn btn-primary ml-2" @click="updateTestTime()">add</button>
                </div>
              </div>
            </div>
          </div>
        </div>        

        <!-- Members -->
        <div v-if="owner && slots" class="row mb-4">
          <!-- Owner -->
          <div class="col-12 col-lg-6 mb-4" :class="sOrder.member_count == 1 ? 'offset-lg-6' : ''">
            <div class="user-group-header mb-3">Организатор</div>
            <shared-order-member :pSlot="slots[1]" />
          </div>
          <!-- Other Members -->
          <div  v-if="sOrder.member_count > 1" class="col-12 col-lg-6">
            <div class="user-group-header mb-3">Участники закупки</div>
            <!-- Members List -->
            <div v-for="(n, i) in sOrder.member_count" :key="i">
              <template
                v-if="
                  slots[n] == undefined || 
                  slots[n].user == undefined || 
                  slots[n].user.id == undefined || 
                  slots[n].user.id != owner.id
                "
              >
                <!-- Member -->
                <shared-order-member :pSlot="slots[n]" />              
                <!-- Kick -->
                <div v-if="slots[n].user != undefined && isAdmin"                  
                  class="member-kick"
                >
                  <span  @click="kickUserShow=slots[n].user.id; " style="cursor: pointer;">Удалить участника</span>
                </div>
              </template>
              <!-- Line -->
              <hr v-if="n < sOrder.member_count && n > 1" class="my-4">              
            </div>
            <!-- Join -->
            <div class="d-flex justify-content-center mt-3">
              <div>
                <button v-if="!userIn && !isFull" @click="join()" class="x-btn" style="height:50px">Стать участником</button>
                <juge-errors :errors="errors" />
              </div>              
            </div>            
          </div>
        </div>

        <hr class="my-4">

        <!-- Info -->
        <div class="row" v-if="sOrder">
          <div class="col-12 col-lg-6 offset-lg-6">

            <!-- Price -->
            <div v-if="sOrder && 0">
              <div class="label">
                Стоимость вашего участия
              </div>
              <div class="value">
                {{sOrder.user_price}}р
              </div> 
              <div class="value">
                Финальная стоимость организационного сбора для вас будет рассчитана исходя из количества участников закупки. Итоговая стоимость организационного сбора {{sOrder.full_price}}р на всех
              </div>
            </div>

            <!-- Weight -->
            <div>
              <!-- <hr class="my-30"> -->
              <div style="display: flex; justify-content: space-between;">
                <div>
                  <div class="d-flex">
                    <div class="d-flex">
                      <span class="label">Макс. бесплатный вес - </span>
                      <span class="value">{{sOrder.user_weight}}кг</span>                   
                    </div>               
                  </div>
                  <div v-if="userIn">
                    <span class="label">вес вашей корзины - </span>
                    <span class="value">{{memberWeight}}кг</span>
                  </div>
                  <div v-if="userIn" class="value mt-2">
                    изменить можно до {{moment(sOrder.order_close).locale("ru").format('LLL')}}
                  </div>
                </div>                
                <div style="max-width: 20px;">
                  <div style="direction: rtl;" >
                    <a href="/rules#weight">
                      <span class="mt-2 ml-3 info-icon" style="color:black; text-decoretion:none"></span>
                    </a>
                  </div>                  
                  <button v-if="isAdmin && editable" @click="goToCart()" class="edit float-right">изменить</button>
                </div> 
              </div>
            </div>          

            <!-- Comment -->
            <div v-if="0">
              <hr class="my-30">
              <div>
                <span class="label">КОММЕНТАРИЙ К ЗАКУПКЕ</span>
                <button v-if="isAdmin && editable" @click="goToEdit()" class="edit float-right">изменить</button>
              </div>
              <div>
                <span class="value">{{(sOrder.comment && sOrder.comment.body != undefined) ? sOrder.comment.body : ''}}</span>
              </div>
            </div>

            <!-- Date/Time -->
            <div>
              <hr class="my-30">
              <div>
                <span class="label">дата и время доставки</span>
                <button v-if="isAdmin && editable" @click="goToEdit()" class="edit float-right">изменить</button>
              </div>
              <div class="value">
                <div>{{moment(sOrder.delivery_date).locale("ru").format('LL')}}</div>
                <div>
                  {{sOrder.delivery_time_from.replace(':00:00', ':00')}} - 
                  {{sOrder.delivery_time_to.replace(':00:00', ':00')}}
                </div>
              </div> 
            </div>
            
            <!-- Address -->
            <div>
              <hr class="my-30">
              <div class="label">
                Адрес доставки
              </div>
              <div class="value">
                {{sOrder.address.street}} {{sOrder.address.appart}}
              </div> 
            </div>

            <!-- Checkout -->
            <div v-if="userIn">
              <hr class="my-30">
              <div>
                <span class="label">Ваши данные</span>
                <button v-if="isAdmin && editable" @click="showModalContacts=true" class="edit float-right">изменить</button>
              </div>
              <div class="checkout-user-data">
                <div>Имя:</div><div class="value">{{order.name}}</div>
                <div>Телефон:</div><div class="value">{{order.phone}}</div>
                <div>E-mail:</div><div class="value">{{order.email}}</div>
              </div>
              <x-popup :title="'Изменить'" :active="showModalContacts" @close="showModalContacts=false" id="contacts-edit-modal">
                <checkout-contact v-model="checkout.contacts" :no-cache="true"/>
                <div class="d-flex justify-content-center">
                  <button @click="checkoutEdit();" type="button" class="x-btn">Сохранить</button>
                </div>
              </x-popup> 
            </div>

            <!-- Comment -->
            <div >
              <hr class="my-30">
              <div>
                <span class="label">Комментарий к заказу</span>
                <button v-if="isAdmin && editable" @click="showModal.comment = true" class="edit float-right">
                  <span v-if="order.comment && order.comment != undefined && order.comment != ''" style="">
                    изменить
                  </span>
                  <span v-else>
                    указать
                  </span>                  
                </button>
              </div>
              <div>
                <span v-if="order.comment && order.comment != undefined && order.comment != ''" class="value">{{order.comment}}</span>
                <span v-else class="value" style="font-style:italic"><i>Не указано</i></span>
              </div>
              <x-popup :title="'Изменить'" :active="showModal.comment" @close="showModal.comment=false" id="comment-edit-modal">
                <checkout-comment v-model="checkout.comment" :no-cache="true"/>
                <div class="d-flex justify-content-center">
                  <button @click="checkoutEdit();" type="button" class="x-btn">Сохранить</button>
                </div>
              </x-popup>  
            </div>

            <!-- Pay method -->
            <div>
              <hr class="my-30">
              <div>
                <span class="label" style="">способ оплаты</span>
                <button v-if="userIn && isOpen" @click="showModal.payMethod = true" class="edit float-right">
                  <span v-if="!order || order.pay_method == undefined || order.pay_method == 0" 
                    style="color: rgb(235, 87, 87);text-decoration-color: red; text-decoration-line: underline;"
                  >
                    указать
                  </span>
                  <span v-else>
                    изменить
                  </span>
                </button>
              </div>
              <div>
                <span class="value">
                  <span v-if="!order || order.pay_method == undefined || order.pay_method == 0" style="color:rgb(235, 87, 87); font-style:italic">
                    <i>Не указано</i>
                  </span>
                  <span v-else>
                    <template v-if="order.pay_method == 'cash'">
                      Наличные
                    </template>
                    <template v-else-if="order.pay_method == 'cart'">
                      Карта
                    </template>
                    <template v-else-if="order.pay_method == 'transfer'">
                      По банковским реквизитам
                    </template>
                  </span>
                </span>
              </div>
              <x-popup :title="'Изменить'" :active="showModal.payMethod" @close="showModal.payMethod=false" id="pay-method-edit-modal">
                <checkout-paymethod v-model="checkout.pay_method" :no-cache="true"/>
                <div class="d-flex justify-content-center">
                  <button @click="checkoutEdit();" type="button" class="x-btn">Сохранить</button>
                </div>
              </x-popup>  
            </div>

            <!-- Final summ -->
            <div v-if="userIn">
              <hr class="my-30">
              <div>
                <span class="label" style="color: #eb5757;">сумма вашего заказа</span>
                <button v-if="isAdmin && editable" @click="goToGallery()" class="edit float-right d-lg-none">изменить</button>
              </div>
              <div>
                <span class="value">{{orderSum == false ? '' : orderSum+'p'}}</span>
              </div>
            </div>



          </div>
        </div>


        <!-- Actions -->
        <div class="row" v-if="sOrder">
          <div class="col-12 col-lg-6 offset-lg-6">
            <!-- Actions -->
            <div class="mb-5">
              
              <hr class="my-30">
              <!-- Edit order -->
              <div v-if="isAdmin && editable" class="mb-3">
                <button @click="goToEdit()" class="action">
                  Редактировать 
                </button>
                <span style="font-size:16px;color: rgba(0, 0, 0, 0.6);">
                  (Вы можете вносить изменения в дату и время закупки пока к ней никто еще не присоединился)
                </span>                
              </div>
              <!-- Cancel order -->
              <div v-if="isAdmin && sOrder.status.id > 0 && isOpen">
                <!-- <button @click="sOrderCancel()" class="action">Отменить закупку</button> -->
                <button @click="cancelOrderShow=true;" class="action">Отменить закупку</button>
              </div>     
              <!-- Exit order -->
              <div v-if="userIn && !isAdmin" 
                class="member-kick ml-0"
              >
                <span  @click="kick(user.id)" style="cursor: pointer;">Выйти из закупки</span>                  
              </div>
            </div>

            <!-- Big Action -->
            <div v-if="isOpen">
              <button v-if="userIn && items <= 0" 
                @click="goToGallery()" 
                class="x-btn"
              >
                Начать собирать заказ
              </button>

              <!-- <button v-if="userIn && !confirmable && memberWeight > 0 && !confirm"
                @click="goToCheckout()"  
                class="x-btn"
              >
                Оформить заказ
              </button> -->

              <div v-if="userIn && memberWeight > 0 && confirm != 1">
                <shared-order-confirm :fast="true"/>
              </div>
              <div v-if="confirm">
                <span ><b style="color: limegreen!important; font-size: 22px;">Заказ оформлен!</b></span>
              </div>
            </div>
          </div>
        </div>


        <!-- Confirm -->
        <!-- <div class="row">
          
        </div> -->
        
        

        <div v-if="0">

          <h1 class="m-3">Формирование коллективной закупки</h1>

          <!-- Loading -->
          <div v-if="!sOrder" class="d-flex m-5" style="justify-content: center;">
            <span style="font-size: 48pt;">🍌🍌</span>
          </div>
          
          <div v-if="sOrder" class="row">
            <!-- Pay -->
            <!-- <div class="col-4">
              <h4>Оплата</h4>
              <div>К оплате: {{sOrder.full_price}} </div>
              <div>Оплачено: {{sOrder.payed}}</div>
            </div> -->
            
            <!-- Invite -->
            <div v-if="shareLink" class="col-4 border">
              <h4>Пригласить</h4>

              
              <div>
                <span class="text-primary">{{shareLink}}</span>
              </div>
              
              <div>
                <telegram-button
                  :shareUrl="shareLink"
                  :description="shareDescription"
                />
                <whatsapp-button
                  :shareUrl="shareLink"
                  :description="shareDescription"
                />
                <vkontakte-button
                  :shareUrl="shareLink"
                  :description="shareDescription"
                />
                <div>
                  https://github.com/Alexandrshy/vue-share-buttons
                </div>
              </div>
            </div>

            <!-- Info -->
            <div v-if="sOrder.status != undefined" class="col-4 border">
              <h4>Данные заказа</h4>
              <!-- Status -->
              <div>
                <h5>Статус</h5>
                <div>
                  <span :class="sOrder.status.id == 0 ? 'text-danger' : ''">{{sOrder.status.name}}</span>              
                </div>
              </div>
              <!-- Address -->
              <div>
                <h5>Адрес</h5>
                <div>{{sOrder.address.street}} {{sOrder.address.appart}}</div>
              </div>
              <!-- Time Date -->
              <div>
                <h5>Доставка</h5>
                <div>{{moment(sOrder.delivery_date).locale("ru").format('LL')}}</div>
                <div>{{sOrder.delivery_time_from}} - {{sOrder.delivery_time_to}}</div>
              </div>
            </div>

            <!-- Timers -->
            <div class="col-4 border">
              <!-- Pay -->
              <!-- <div v-if="sOrder.status != undefined" >
                <h5>Оплата до</h5>
                <div>{{moment(sOrder.pay_close).locale("ru").format('LLLL')}}</div>
              </div> -->
              <!-- Close -->
              <div v-if="sOrder.status != undefined">
                <h5>Закрытие</h5>
                <div>{{moment(sOrder.order_close).locale("ru").format('LLLL')}}</div>
              </div>
              <!-- Test time -->
              <div v-if="sOrder.status != undefined" class="border p-2" style="background-color: #fb00ff40;">
                <h5>Test time</h5>
                <div><b>now:  </b>{{moment().locale("ru").format('LLLL')}}</div>
                <div><b>fake: </b>{{moment(sOrder.test_time).locale("ru").format('LLLL')}}</div>
                <div class="d-flex">
                  <label for="t-h">Hours: </label><input v-model="test.hours"  type="number" name="hour" id="t-h" style="width:60px">
                  <label for="t-m" class="ml-3">Minutes: </label><input v-model="test.minutes"  type="number" name="minute" id="t-m"  style="width:60px">
                  <button @click="updateTestTime()" class="btn btn-primary ml-3">add</button>
                </div>
              </div>
            </div>

            <!-- Weight -->
            <div class="col-4 border">
              <h4>Вес</h4>
              <div v-if="weights">
                <div><b>Общий</b></div>
                <div>Доступно: {{sOrder.full_weight}}кг</div>
                <div>Использовано: {{weights.overall}}кг</div>
                <div><b>Мой</b></div>
                <div>Доступно: {{sOrder.user_weight}}кг</div>
                <div>Использовано: {{weights[user.id]}}кг</div>
                <!-- <div>не использовано: {{25 - weights.overall}}кг</div> -->
              </div>
            </div>

            <!-- Details -->
            <div class="col-4 border">
              <h4>Личнные данные</h4>
              <checkout-contact class="checkout-div " v-model="data.contacts" />
            </div>
            
            <!-- Users -->
            <div class="col-4 border">
              <div v-if="sOrder && userIn">
                <h4>Участники</h4>

                <hr>

                <!-- Members -->
                <template v-if="slots">
                  <div v-for="(n, i) in sOrder.member_count" :key="i">
                    <!-- Member -->
                    <div>
                      <div v-if="slots[n].user != undefined">
                        <!-- Name -->
                        <span :class="slots[n].user.id == user.id  ? 'text-info' : ''">
                          <span v-if="slots[n].user.id == sOrder.owner_id">👑</span> {{slots[n].user.name}} {{slots[n].user.email}}
                        </span>
                        <!-- kick -->
                        <span v-if="isAdmin">
                          <button v-if="slots[n].user.id != user.id" @click="kick(slots[n].user.id)" class="btn btn-danger btn-sm">
                            выкинуть 🥾
                          </button>
                        </span>
                        <!-- Weight -->
                        <div v-if="weights">
                          Вес: {{weights[slots[n].user.id]}}
                        </div>  
                      </div>
                      <!-- Invite -->
                      <div v-else>
                        <i style="font-style: italic;">Invite!</i> 
                      </div>
                    </div>

                    <!-- Pay -->
                    <div>
                      <!-- <div v-if="slots[n].pay == undefined">
                        <button 
                          @click="pay(user.id, n)" 
                          class="btn btn-info"
                        >
                          Оплатить {{sOrder.user_price}}p
                        </button>
                      </div> -->
                      <!-- Pay -->
                      <!-- <div v-else>
                        <span class="text-success">Оплачено</span>
                        <span>
                          {{slots[n].pay.user.name}} {{slots[n].pay.user.email}}
                        </span>
                      </div> -->
                    </div>

                    <hr>
                  </div>
                </template>

                <!-- Change member count -->
                <div v-if="isAdmin" class="form-group">
                  <label for="member-count">Количество участников: <b>{{changeMemberCount}}</b></label>
                  <input v-model="changeMemberCount" type="range" class="form-control" id="member-count" min="1" max="5">
                  <button @click="post({'member_count':changeMemberCount})" class="btn btn-sm btn-success">Сохранить</button>
                </div>

              </div>
              <button v-if="!userIn" @click="join()" class="btn btn-primary">Присоединиться</button>
            </div>   

            <!-- Cancel -->
            <div v-if="isAdmin && sOrder.status.id > 0" class="col-4 border">
              <button @click="sOrderCancel()" class="btn btn-danger m-3">Отменить закупку</button>
            </div>       

          </div>

        </div>



      </div>


      <!-- Other -->
      <template>
        <login-modal :p-show="showLogin" :p-show-type="'signup'" @close="showLogin=false" />
        <x-popup :title="'Спасибо, что открыли закупку!'" :active="0">
          Мы предложим вашим соседям присоединиться к вашей закупке. Участников закупки вы сможете увидеть в вашем личном кабинете в разделе закупки
        </x-popup>  
        <!-- Cancel order -->
        <x-popup :title="'Отменить закупку?'" :active="cancelOrderShow" @close="cancelOrderShow=false" id="share-order-cancel-modal">
          <div class="m-3">
            Вы уверены, что хотите отменить закупку? Восстановить её после удаления будет не возможно.
          </div>
          <div style="justify-content: space-evenly; display:flex">
            <button @click="cancelOrderShow=false" class="x-btn x-btn-trans">Отмена</button>
            <button @click="sOrderCancel()" class="x-btn x-btn-red">Отменить Закупку</button>
          </div>
        </x-popup>
        <!-- Kick -->
        <x-popup :title="'Исключить участника?'" :active="kickUserShow" @close="kickUserShow=false" id="share-order-kick-modal">
          <div class="m-3">
            Вы действительно хотите удалить этого участника из закупки? Это действие отменить будет нельзя
          </div>
          <div style="justify-content: space-evenly; display:flex">
            <button @click="kickUserShow=false" class="x-btn x-btn-trans">Отмена</button>
            <button @click="kick(kickUserShow);kickUserShow=false" class="x-btn x-btn-red">Исключить</button>
          </div>
        </x-popup>        
        <!-- Neighbor -->
        <x-popup v-if="neighborAnnouceShow" :title="'Спасибо, ваша заявка принята!'" :active="neighborAnnouceShow" @close="neighborAnnouceShow=false" id="share-order-neighbor-modal">
          <div class="m-3">
            Мы постараемся найти того, кто присоединится к вашей закупке. После присоединения к вашей закупке других участников, вы узнаете об этом на странице закупки
          </div>
        </x-popup>
      </template>

    </juge-main>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
import copy from 'copy-to-clipboard';
export default {
data(){return{
  moment:moment,
  //Checkout
  checkout:{},
  showModal:{},
  showModalContacts:false,
  //
  changeMemberCount:1,
  test:{},
  data:{},
  shareDescription:"Смотри какой крутой сервис! Давай вместе?",
  weights:false,
  showLogin:false,
  copied:false,
  cancelOrderShow:0,
  kickUserShow:0,
  neighborAnnouceShow:0,
  errors:[],
  time:1,
}},
computed:{
  ...mapGetters({
    cart:'cart/getCart',
    sOrders:    'sharedOrder/get',
    user:       'user/get',
  }),
  shareLink(){
    if(!this.link) return false;
    return window.location.origin+'/shared/order/' + this.link;
  },
  link(){
    if(!this.sOrder || this.sOrder.link == undefined || !this.sOrder.link) return false;
    return this.sOrder.link;
  },
  sOrder(){
    if(this.sOrders == undefined || this.sOrders.length < 1) return false;
    return this.sOrders[0];
  },
  users(){
    if(!this.sOrder || this.sOrder.users == undefined || this.sOrder.users.length < 1) return [];
    return this.sOrder.users;
  },
  owner(){
    if(this.users.length < 1) return false;
    let user = this.users.find(x => x.id == this.sOrder.owner_id);
    if(user == -1) return false;
    return user;
  },
  slots(){
    if(!this.sOrder || this.sOrder.member_count == undefined || this.sOrder.member_count < 1) return [];
    if(this.sOrder.users == undefined) return [];

    let slots = []
    for (let i = 1; i <= this.sOrder.member_count; i++) {
      let user = this.sOrder.users.find(x => x.slot == i);
      let pay = this.sOrder.pays.find(x => x.slot == i);
      //order
      let order = false;
      if(user != undefined && user.id > 0)order = this.sOrder.orders.find(x => x.customer_id == user.id);
        
      if(pay != undefined){
        pay.user = this.users.find(x => x.id == pay.user_id);
      }

      slots[i] = {
        n:i,
        user:user,
        pay:pay,
        order:order
      };      
    }

    return slots;

  },
  userIn(){
    let r = false;
    if(!this.users || this.users.length < 1) return r;
    
    this.users.forEach(user => {
      if(user.id == this.user.id) r = true;
    });

    return r;

  },
  isAdmin(){
    if(this.user == undefined && !this.user) return false;
    if(!this.sOrder || this.sOrder.owner_id == undefined || this.sOrder.owner_id < 1) return false;
    if(this.user.id == this.sOrder.owner_id) return true;
    return false;
  },
  editable(){
    if(!this.sOrder || this.sOrder.editable == undefined) return false;

    return this.sOrder.editable
  },
  isFull(){
    if(!this.sOrder || this.sOrder.member_count == undefined || this.sOrder.users == undefined) return true;
    if(this.sOrder.users.length < 1) return true;
    if(this.sOrder.member_count > this.sOrder.users.length) return false;

    return true;
  },
  order(){
    if(this.user == undefined && !this.user) return false;
    if(!this.sOrder || this.sOrder.orders == undefined || this.sOrder.orders.length <= 0) return false;

    let order = this.sOrder.orders.find(x => x.customer_id == this.user.id);
    if(!order || order.id == undefined) return false
    return order;

  },
  items(){
    if(!this.order || this.order.items == undefined) return false;
    return this.order.items.length;
  },
  confirm(){
    if(this.user == undefined && !this.user) return false;
    if(!this.sOrder || this.sOrder.orders == undefined || this.sOrder.orders.length <= 0) return false;

    let order = this.sOrder.orders.find(x => x.customer_id == this.user.id);
    if(!order || order.x_confirm == undefined) return false
    return order.x_confirm;    
  },
  memberWeight(){
    if(!this.order || this.order.xData == undefined) return false;
    return this.order.xData.fullWeight;
  },
  orderSum(){
    if(!this.order || this.order.x_total == undefined) return false;
    return this.order.x_total;
  },
  confirmable(){
    if(this.order == undefined || this.order.confirmable == undefined) return false;
    return this.order.confirmable;
  },
  untilClose(){
    if(this.sOrder == undefined || this.sOrder.order_close == undefined) return false;    
    let triger = this.time;
    return moment(this.sOrder.order_close).unix() - moment().unix();
  },
  allConfirmed(){
    let c = -1;
    if(!this.sOrder || this.sOrder.orders == undefined || this.sOrder.orders.length <= 0) return c;    
    c = 1;
    this.sOrder.orders.forEach(order => {
      if(!order.x_confirm) c = 0;
    });
    return c;
  },
  isOpen(){
    if(!this.sOrder || this.sOrder.status_id == undefined) return false;
    if(!(this.sOrder.status_id == 100 || this.sOrder.status_id == 200)) return false;
    return true;
  }

},
watch:{
  sOrder: function (val, oldVal) {
    if(!this.sOrder || this.sOrder.member_count == undefined) return;
    this.changeMemberCount = this.sOrder.member_count;    
    this.getWeights();
    return;
  },    
  showModalContacts: function (val, oldVal) {
    if(!val) return;
    if(!this.order) return;
    this.checkout.contacts = {};
    this.checkout.contacts.name = this.order.name;
    this.checkout.contacts.phone = this.order.phone;
    this.checkout.contacts.email = this.order.email;
  },
},
async mounted(){

  if(this.sOrder){
    await this.update();
  }  


  
  //Neighbor accounce
  if(this.$route != undefined && this.$route.query != undefined  && this.$route.query.neighbor != undefined && this.$route.query.neighbor){
    this.neighborAnnouceShow = 1;
    this.$router.replace({});
  }

  this.timerTrigger();


},
methods:{
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
    'update':'sharedOrder/update',
  }),
  timerTrigger(){
    setTimeout(() => { 
      this.timerTrigger();
      this.time ++; 
    }, 333);     
  },
  copyInviteLink(){
    copy('https://neolavka.ru/shared/order/' + this.link);
    this.copied = true;
  },
  goToEdit(){
    if(!this.link) return;
    location.href = '/shared/order/edit/' +this.link;
  },
  async open(){
    let r = await ax.fetch('/shared/order/open',{},'put');
    if(r){
      window.location.href = '/shared/order/'+r.link;
    }
  },
  async post(data){
    data.id = this.sOrder.id;
    let r = await ax.fetch('/shared/order',data,'post');
    if(r){this.get();}
  },
  async sOrderCancel(){
    let r = await ax.fetch('/shared/order',{id:this.sOrder.id},'delete');
    if(r){
      // this.get();
      window.location.href = "/";
    }
  },
  async join(){
    this.errors = [];
    if(!this.user){
      this.showLogin = true;
      return;
    }
    let r = await ax.fetch('/shared/order/join',{'link':this.link},'post');
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}
    if(r){window.location.reload();}
  },
  async pay(userId,slot){
    let r = await ax.fetch('/shared/order/pay',{'order_id':this.sOrder.id, 'user_id':userId, 'slot':slot},'put');
    this.get();
  },
  async getWeights(){
    let r = await ax.fetch('/shared/order/weights',{id:this.sOrder.id});
    if(r){
      this.weights = r;
    }
  },
  async kick(userId){
    let r = await ax.fetch('/shared/order/kick',{'sOrderId':this.sOrder.id,'userId':userId},'delete');
    this.get();
  },
  async goToGallery(){
    location.href = '/';
  },
  async goToCart(){
    location.href = '/cart';
  },
  async goToCheckout(){
    location.href = '/shared/order/checkout/'+this.link;
  },    
  async checkoutEdit(){
    //Refresh errors
    this.errors = [];
    console.log(this.checkout);
    let data = this.checkout;
    data.id = this.order.id;
    let r = await ax.fetch('/order/customer',data,'post');

    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

    //Success
    this.showModal = {};
    this.showModalContacts = false;
    
    this.get(this.link);
  },

  //TEST
  async updateTestTime(){
    let r = await ax.fetch('/shared/order/test/time',{'id':this.sOrder.id,'test':this.test},'post');
    this.get();
  },
},
}
</script>

<style scoped>
  .shared-order-timer-container{  
    background-color: #e7dfdc;
    border: 1px solid #cbcbcb;
    border-radius: 10px;
  }
  .shared-order-timer{  
    font-weight: 600;
    font-size: 26px;
    line-height: 150%;  
  }
  .shared-order-timer-text{
    width: 170px;
  }
  .shared-order-timer-description{
    font-size: 16px;
    line-height: 160%;
  }
  .member-kick{  
    text-decoration-line: underline;
    font-size: 14px;
    margin-left: 110px;
    margin-top: 10px;
  }
  .congratz{
    font-size: 22px;
    font-style: normal;
    font-weight: 600;
    line-height: 140%;    
  }  
  .top-text{
    font-size: 18px;
    max-width: 513px;
    font-style: normal;
    font-weight: normal;
    line-height: 150%;
  }
  .user-group-header{
    font-size: 18px;
    line-height: 110%;  
    text-transform: uppercase;
    font-weight: 600;
  }
  .label{
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
  }
  .value{
    font-size: 16px;
    color: rgba(0, 0, 0, 0.6);
  }
  .action{
    text-align: left;
    text-decoration-line: underline;
    font-size: 16px;
  }

  .checkout-user-data {
    display: grid;
    grid-template-columns: auto 1fr;
  }

  .checkout-user-data  .value{
    margin-left: 10px;
  }


  /* Desktop */
  @media screen and (min-width: 992px){
    
    .shared-order-timer{  
      font-size: 50px;
    }
    .shared-order-timer-text{      
      width: 314px;
      font-size: 20px;
      line-height: 140%;
    }
    .shared-order-timer-description{
      width: 519px;
      font-size: 20px;
      line-height: 160%;
    }
    .congratz{
      max-width: 770px;
      font-size: 50px;
    }    
    .top-text{
      max-width: 513px;
      font-size: 26px;
    }    
    .user-group-header{
      font-size: 30px;
    }    
    .member-kick{  
      font-size: 16px;
      margin-left: 147px;
    }  

  }
  


</style>