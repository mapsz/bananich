<template>

  <div>

    <site-header></site-header>

    <main class="cart-page">
      <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active">Корзина</li>
          </ol>
        </nav>

        <div class="mt-4 mt-sm-0">
          <h1 class="title-page">Корзина</h1>
        </div>

        <div class="row content-page">

          <div class="col-lg-8">
            <div v-if="cart.items != undefined && cart.items.length == 0">Корзина пуста!</div>
            <div v-if="cart.items != undefined && cart.items.length > 0" class="content">
              <form action="">

                <div v-for='(item,i) in cart.items' :key='i' class="cart-item">                  
                  <div>
                    <div class="cart-name">{{item.name}}</div>
                    <span class="cart-weight">{{item.unit_digit * item.count}} {{item.unit_name}}</span>
                  </div>
                  
                  <div class="cart-counter">
                    <button @click="editItem({id:item.product_id, count:item.count-1})" class="back">-</button>
                    <input class="number" :value="item.count" type="text">
                    <button @click="editItem({id:item.product_id, count:item.count+1})" class="next">+</button>
                  </div>
                  
                  <div class="cart-price">{{item.final_price}}</div>
                  <div class="cart-points">+{{Math.round(item.final_price / 10)}}Б</div>
                  <div @click="removeItem(item.product_id)" class="cart-remove"></div>
                </div>

              </form>
              <button @click="cartReset()" class="url">Удалить все</button> 
            </div>
          </div>
          <div class="col-lg-4">
            <!-- Sitebar -->
              <div class="cart-sitebar">
                <div class="cart-delivery">
                  
                  <div class="cart-delivery-header d-flex justify-content-between">
                    <span>Доставка</span>
                    <template>
                      <span v-if="(freeShipping - cart.final_summ) > 0">200р</span>
                      <span v-else>Бесплатно</span>
                    </template>
                  </div>                  
                  <div v-if="(freeShipping - cart.final_summ) > 0" class="d-flex">
                    <div class="cart-delivery-ico"><img src="image/icons/free.svg" alt="Free"></div>
                    <div class="cart-delivery-text">До бесплатной доставки закажите еще на <span>{{freeShipping - cart.final_summ}}</span><br><a href="/catalogue" class="url">Докупить</a></div>
                  </div>
                </div>
                <div v-if="user" class="cart-bonuse">
                  <div class="d-flex">
                    <div class="cart-bonuse-ico">
                      <img src="image/icons/bonus.svg" alt="Bonuse">
                    </div>
                    <div class="cart-bonuse-text">
                      У вас 500 активных бонусов!
                      <span style="color:orange">todo</span><!--  @@@todo -->
                    </div>
                  </div>
                  <hr>
                  <!-- Bonus -->
                  <div class="mb-4">
                    <bonus-button></bonus-button>
                  </div>
                  <form class="cart-promo">
                    <input type="text" placeholder="Ввести промокод" class="cart-promo-input">
                    <button class="cart-promo-btn">Применить</button>
                  </form>
                </div>
                <buy-info />

                <span v-if="settings.min_order > cart.final_summ"
                  style="    
                    color: red;
                    font-size: 14pt;
                  "
                >
                  Минимальная сумма заказа {{settings.min_order}}
                </span>
                <a v-else href="/checkout" class="btn btn-yellow btn-thick">Оформить заказ</a>
                

                <div v-if="user && !(settings.min_order > cart.final_summ)" class="cart-message">
                  <div class="cart-message-ico">
                    <img src="image/icons/bonus.svg" alt="Bonus">
                  </div>
                  <div class="cart-message-text">
                    <span>За этот заказ вы получите {{Math.round(cart.final_summ / 10)}} бонусов! </span> 
                    <div class="cart-message-date">
                      Успей потратить за 21 день!
                      <!-- <div class="cart-message-time"><span>01.12.2020</span> I <span>18:10</span></div>
                      <span style="color:red; font-size:8pt">!!(дата\время неизвестно?)</span> todo @@@ -->
                    </div>
                  </div>
                </div>
              </div>
            <!-- Sitebar -->
          </div>
        </div>
      </div>
    </main>

    <site-footer></site-footer>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    //
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      settings:'settings/beautyGet',
      user:'user/get',
    }),
    freeShipping: function(){
      return this.settings.free_shipping;     
    }
  },
  mounted(){
    this.getSettings();
  },
  methods:{
   ...mapActions({
      'editItem':'cart/editItem',
      'cartReset':'cart/cartReset',
      'removeItem':'cart/removeItem',
      'getSettings':'settings/fetch',
    }),  
    getItem(id){
      return this.cart.items.find(x => x.product_id == id);
    }
  },
}
</script>

<style scoped>
  .active {
      color: inherit !important;
      text-decoration: inherit !important;
      background-color: inherit !important;
  }

  .btn-yellow {
      background: #FBE214;
      border: 1px solid #FBE214;
      box-sizing: border-box;
      border-radius: 30px;
      color: #000000;
      width: 100%;
      height: 40px;
      line-height: 40px;
      font-size: 16px;
      text-align: center;
      cursor: pointer;
      display: inline-block;
      padding: 0 20px;
  }

</style>