<template>
<div>
  <site-header/>

  <main class="cart-page">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="#">Корзина</a></li>
          <li class="breadcrumb-item active">Оформление заказа</li>
          <li class="breadcrumb-item active">Подтверждение заказа</li>
        </ol>
      </nav>

        <div class="d-flex mt-4 mt-sm-0">
          <a href="#!" class="arrow-back"><img src="image/arrow.svg" alt="arrow"></a>
          <h1 class="title-page">Подтверждение заказа</h1>
        </div>

      <div class="row content-page">

        <div class="col-lg-8">
          <div class="content">
            <div class="checkout-title">Ваши данные</div>
            
            <span style="color:orange">todo</span><!--  @@@todo -->
            <div class="checkout-form">

              <div class="form-group"> 
                <div class="form-content active bold">Констанция Константинопольская</div>
              
              </div>

              <div class="form-group">
                <div class="form-content active">+7 (999) 999-88-77</div>
              </div>

              <div class="form-group">
                <div class="form-content active">Ivanov_Ivan@mail.ru</div>
              </div>

              <div class="form-group">
                <div class="form-label">Адрес доставки</div>
                <div class="form-content form-content-name active">ул. Ленина 57. кв 9</div>
              </div>

              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <div class="form-label">Дата доставки</div>
                    <div class="form-content form-content-name active">01.05.2020</div>
                  </div>
                </div>
                <div class="col-5">
                  <div class="form-group">
                    <div class="form-label">Время доставки</div>
                    <div class="form-content form-content-name active">с 9:00 до 12:00</div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <div class="form-label">Способ оплаты</div>
                    <div class="form-content form-content-name active">Наличные</div>
                  </div>
                </div>
                <div class="col-5">
                  <div class="form-group">
                    <div class="form-label">Упаковка</div>
                    <div class="form-content form-content-name active">Стандарт (ящик)</div>
                  </div>
                </div>
              </div>

              <div class="form-group m-0">
                <div class="form-label">Способ подтверждения заказа</div>
                <div class="form-content form-content-name active">Вам позвонит оператор</div>
              </div>
            </div>

            <div class="checkout-title">Товары</div>

            <div class="row">              
              <cart-list></cart-list>
            </div>

        

          </div>
        </div>
        <div class="col-lg-4">
          <!-- Sitebar -->
            <div class="cart-sitebar">
            
              <buy-info />

              <div class="align-items-center mb-4">                
                <bonus-button></bonus-button>
              </div>
              <button class="btn-yellow btn-thick">Подтвердить заказ</button>
              <a href="/cart" class="url text-center mt-4">Редактировать заказ</a>
            </div>
          <!-- Sitebar -->
        </div>
      </div>
    </div>
  </main>
  
  <site-footer/>
</div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      cart:'cart/getCart'
    }),    
  },    
}
</script>

<style>

</style>