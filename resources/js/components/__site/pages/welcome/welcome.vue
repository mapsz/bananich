<template>
  <div>
    <juge-main>
        
      <div class="container">


        <!-- Name moto -->
        <div class="header my-5">
          <b>NEOLAVKA</b> - новый подход к рациональным покупкам
        </div>

        <!-- Desciprion -->
        <div class="row">
          <div class="col-12 col-lg-6 mb-3">
            Вы покупаете абсолютно все товары нашего сайта по цене себестоимости, а платите только небольшую фиксированную сумму за доставку и наш сервис (сервисный сбор).
          </div>
          <div class="col-12 col-lg-6" style="display: flex;align-items: center;">
            <button @click="goToGallery()" class="x-btn">Перейти к каталогу оптовых цен</button>
          </div>
        </div>

        <div class="header my-5">
          <b>Почему NEOLAVKA - это здорово?</b>
        </div>

        
        <!-- 1 -->
        <!-- <div class="row mb-lg-100">
          <div class="col-12 col-lg-6">
            <div class="header mb-4">
              1. Это очень <b>просто</b>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="wariki mb-5">
              <ul>
                <li>Открываете закупку</li>
                <li>Приглашаете соседей или друзей принять участие в закупке</li>
                <li>Каждый формирует свой заказ</li>
                <li>Каждый участник закупки оплачивает свою часть закупки и сервисного сбора по индивидуальной накладной курьеру по прибытии или онлайн по факту сборки.</li>
              </ul>
            </div>

            <div class="mb-5">
              Мы сделали все, чтобы совместные закупки были максимально удобными для вас, поэтому у каждого участника закупки будет:          
            </div>

            <div class="my-3">
              <ul>
                <li>- отдельная корзина</li>
                <li>- отдельная накладная</li>
                <li>- отдельный ящик с заказом</li>
              </ul>
            </div>

            <div class="mb-5">
              <b>Вам не надо ничего считать и распределять вручную!</b>
            </div>

            <div class="announce-block mb-5">
              <b>Вы можете оплатить сервисный сбор индивидуально, но гораздо выгоднее сделать это в формате совместной закупки с соседями:</b>
            </div>
            
          </div>          
          <div class="col-12  mb-5">
            <a name="prices"></a>
            <shared-order-open-blocks />
          </div>
        </div> -->

        <!-- 1 -->
        <div class="row mb-lg-100">
          <div class="col-12 col-lg-6">
            <div class="header mb-4">
              1.Это новый подход к <b>рациональному потреблению</b>
            </div>
          </div>
          <div class="col-12 col-lg-6">    
            <div class="mb-5">
              Neolavka дает возможность приобрести все товары нашего магазина <b>по закупочным ценам </b> в один из предложенных нами интервалов. Вы оплачиваете только сервисный сбор, который мы взимаем за то, что купили, отобрали и доставили вам заказ. 
            </div>
            <div class="mb-5">
              У нас нет  <b>минимальной суммы заказа </b> и доставка всегда осуществляется  <b>до двери клиента. </b>     
            </div>
            <div class="mb-5">
              За счет оптимизации логистики мы существенно снижаем наши расходы. Это позволяет нам зарабатывать не на стоимости товаров, а только на сервисном сборе. Поэтому вы выбираете удобный для вас интервал из предложенных нами. 
            </div>
            <div class="mb-5">
              Во всех районах города есть возможность заказать доставку с оплатой сервисного сбора в размере  <b>300 рублей. </b>  С ростом заказов, количество предлагаемых интервалов с уплатой сервисного сбора 300 рублей будет увеличиваться.
            </div>
            <div class="mb-5">
              В случае, если доступные интервалы/ районы доставок вам не подходят, вы можете создать заявку на доставку за 600 рублей в удобные вам район и временной интервал.
            </div>
            <div class="mb-5">
              Подробнее с условиями доставки и оплаты вы можете ознакомиться <a href="/delivery_and_price">тут</a>.
            </div>
          
          </div>
        </div>

        <!-- Create Blocks -->

        <!-- 2 -->
        <div class="row mb-lg-100">
          <div class="col-12 col-lg-6">
            <div class="header mb-4">
              2. Это очень <b>честно</b>
            </div>
          </div>
          <div class="col-12 col-lg-6">

            <div class="mb-5">
              <b>Обычно наценка магазинов составляет 50-200% </b>
            </div>

            <div class="welcome-list mb-5">
              <ul>
                <li>На фрукты/овощи/чай/кофе наценка обычно 60%, а иногда и больше <b>100%</b> </li>
                <li>На крупы и орехи - <b>70-100%</b></li>
                <li>Самые маленькие наценки обычно на молочную продукцию, бытовую химию и косметику (там розница накручивает от <b>50%</b>).</li>
              </ul>
            </div>

            <div class="announce-block mb-5">
              <b>Мы решили попробовать новую модель:</b><br>
              вы оплачиваете только фиксированный сервисный сбор за наш сервис и доставку, а вся продукция на сайте продается без торговой наценки.
            </div>

          </div>
        </div>


        <!-- 3 -->
        <div class="row mb-lg-100">
          <div class="col-12 col-lg-6">
            <div class="header mb-4">
              3. <b>Высокое качество</b> продуктов 
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-5">
              Мы очень тщательно выбираем продукты, которые добавляем на сайт, и ищем для вас продукты с максимально понятным и натуральным составом. Особенно мы гордимся нашей фермерской продукцией, в которой нет ни одной «Е-шки». Фрукты, овощи и зелень мы закупаем под ваши заказы каждое утро, и отбираем их вручную, поэтому гарантируем, что вам приедет максимально свежая продукция.
            </div>
          </div>
        </div>

        <!-- 4 -->
        <div class="row mb-lg-100">
          <div class="col-12 col-lg-6">
            <div class="header mb-4">
              4. широкий <b>ассортимент</b>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-5">
              Мы очень стараемся сделать так, чтобы всю базовую потребительскую корзину вы смогли купить у нас по закупочным ценам. 
              Ассортимент на нашем сайте же достаточно широк, и мы открыты к диалогу. 
              Все, чего вам не хватает на сайте, вы можете указать в поле "не нашел на сайте" 
              в конце каждого раздела и мы обязательно постараемся добавить запрашиваемую вами позицию на сайт. 
            </div>
          </div>
        </div>

        <!-- 5 -->
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="header mb-4">
              5. ЭТО ЭКОЛОГИЧНО И <b>ОСОЗНАННО</b>
            </div>
          </div>
          <div class="col-12 col-lg-6">        
            <div class="mb-5">
              NEO LAVKA за осознанное потребление. Все, что возможно, мы доставляем в оборотной или перерабатываемой таре. По дефолту, вся продукция к вам приедет в ящике, из которого ее надо будет переложить в свою тару, а ящик отдать курьеру. Однако, если вам совсем не удобен такой вариант, мы предусмотрели дополнительную опцию выбора упаковки для вашего заказа в крафт коробку или крафт пакет.
            </div>

            <div class="announce-block mb-5">
              <b>Давайте пробовать новые форматы магазинов вместе.</b><br>
              От этого всем будет только хорошо
            </div>    

            <div class="mb-5 d-flex justify-content-center justify-content-lg-start">
              <a href="/rules">
                <button class="x-btn">Правила проведения закупок</button>  
              </a>              
            </div> 
          </div>
        </div>


   

      </div>

    </juge-main>
  </div>
</template>

<script>
export default {
data(){return{
  isX:isX,
}},
async mounted() {

  if(this.$route.hash != ""){
    setTimeout(function() { 
      scrollBy(0,-100);
    },250);
  }

  Cookies.set('x_not_first_time');

},
methods:{  
  async goToGallery(){
    location.href = '/';
  },
},

}
</script>

<style scoped>

.header{
  font-size: 25px;
  line-height: 130%;
  text-transform: uppercase;
}

.wariki{
  font-size: 16px;
  line-height: 160%;    
  border-left: 2px solid gray;
  padding-left: 20px;
}
.wariki li {
  font-size: 16px;
  line-height: 160%;
  margin-bottom: 30px;   
  background-color: white;
  width: fit-content;
  padding: 17px 30px;
  border-radius: 30px;
}
.welcome-list li{
  list-style: disc;
  margin-left: 20px;  
  margin-bottom: 16px;
}   
.welcome-list li:last-child{ 
  margin-bottom: 0;
}   

@media screen and (min-width: 992px){
  .header{
    max-width:850px;
    font-size: 44px;
    line-height: 140%;
  }  
  .wariki li {
    font-size: 20px;
    line-height: 180%;
  }

}

</style>