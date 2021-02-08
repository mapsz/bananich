<template>    
<juge-main>

  <div class="container rules">

    <div class="x-header my-5">
      <b>Правила проведения закупок</b>
    </div>


    <div class="row mb-lg-100">
      <div class="col-12 col-lg-6">
        <div class="header mb-4">
          <b>Стоимость</b> доступа
        </div>
      </div>
      <div class="col-12 col-lg-6">

        <div class="mb-3 mb-lg-5">
          На NEO LAVKA выгодно покупать с друзьями! Cервисный сбор включает стоимость доставки. 
          То есть, вы оплачиваете только его, и сами продукты по цене их себестоимости.
        </div>

        <div class="ml-5 bolt-text">
          <b>Чем больше людей участвует в закупке, тем выгоднее.</b>
        </div>
        
        
      </div>          
      <div class="col-12  my-5">
        <shared-order-open-blocks />
      </div>
    </div>  

    <a name="notconfirm"></a>
    <div class="row mb-lg-100">
      <div class="col-12 col-lg-6">
        <div class="header mb-4">
          <b>Условия</b> осуществления закупки
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="mb-3">
          Чтобы совместная закупка состоялась, всем ее участникам необходимо оформить заказы
          <b>до 21.00 дня накануне осуществления доставки.</b>
        </div>
        <div class="mb-5">
          В случае, если изначально закупка была открыта на троих, а заказ оформили только двое участников, 
          сервисный сбор будет делиться между ними поровну. 
          Если заказ оформил один участник- в его накладную будет включена полная стоимость сервисного сбора.
        </div>
      </div>
    </div> 
   
    <div class="row mb-lg-100 mb-5 mb-lg-100">
      <div class="col-12 col-lg-6">
        <div class="header mb-4">
          <b>Редактирование данных</b> совместной закупки
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="mb-4 list">
          Организатор закупки может редактировать следующие данные до того момента, как к закупке присоединится хотя бы один другой участник:
          <ul>
            <li>— Дату и время доставки</li>
            <li>— Адрес доставки</li>
          </ul>
        </div>
        <div class="text-bolt after-list">
          <b>Все участники закупки могут вносить изменения в свои корзины до 21.00 дня накануне доставки.</b>
        </div>
      </div>   
    </div>  

    <a name="weight"></a>
    <div class="row mb-lg-100 mb-5 mb-lg-100">
      <div class="col-12 col-lg-6">
        <div class="header mb-4">
          <b>Общий </b> вес заказа
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="mb-3">
          Максимальный общий вес совместной закупки – 24 кг на всех участников закупки. 
          При создании закупки максимальный вес товаров одного участника закупки определяется путем деления <b>24</b> кг на количество участников закупки.
        </div>
        <div class="announce-block">
          Например, если открывается закупка на троих, то каждый участник сможет заказать максимум по 8 кг (24/3). 
          Каждые дополнительные 5 кг в закупке стоят 50 рублей, и оплачиваются отдельно тем участником, который превысил свой весовой лимит.
        </div>
      </div>
    </div> 

    <div class="row mb-lg-100 mb-5 mb-lg-100">
      <div class="col-12 col-lg-6">
        <div class="header mb-4">
          Особенности <b>доставки </b>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="">
          Доставка совместной закупки производится в пункт, указанный организатором закупки. 
          В случае, если другие участники закупки проживают в том же доме, они могут доплатить 50 рублей за доставку их части закупки прямо до двери.
        </div>
      </div>
    </div>     

    <div class="row mb-lg-100 mb-5 mb-lg-100">
      <div class="col-12 col-lg-6">
        <div class="header mb-4">
          <b>Оплата</b>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="mb-3">
          Сумма заказа и своя часть сервисного сбора  могут быть оплачены участниками закупки
          по факту его получения.
        </div>
        <div class="mb-3">
          <b>
            Для каждого участника закупки формируется личная накладная его части закупки, поэтому вам не придется самостоятельно высчитывать сумму к оплате. 
          </b>
        </div>
        <!-- <div class="mb-3">
          В случае, если водитель осуществил доставку в указанное время, а кто-то из участников закупки не оплатил/ отказался от своей части заказа, эта часть закупки будет отправлена обратно на склад, а оплата доступа к Бананыч Х возвращена не будет.        </div>
        </div> -->
      </div>
    </div>     

  </div>

</juge-main>
</template>

<script>
export default {
async mounted() {
  if(this.$route.hash != ""){
    setTimeout(function() { 
      scrollBy(0,-100);
    },250);
  }
},
}
</script>

<style scoped>

.rules{
  font-size:18px;
}

.bolt-text{
  font-weight: 600;
  font-size: 18px;
  line-height: 150%;
}
.bolt-text:before{
  content: "\1F812";
  position: absolute;
  font-size: 50px;
  margin-left: -50px;
  color: #8AC2A7;
}

.header{
  font-size: 25px;
  line-height: 130%;
  text-transform: uppercase;
}

.list li {
  margin-bottom: 10px;
}

.after-list{
  font-size: 16px;
}

@media screen and (min-width: 992px){
  .after-list{
    font-size: 30px;
  }
  .header{
    max-width:850px;
    font-size: 44px;
    line-height: 140%;
  }
  
  .bolt-text{
    font-size: 30px;
  }
}

</style>