<template>
  <div>
    <juge-main>
        
      <div class="container">

        <div class="moto my-5">
          <b>NEOLAVKA</b> - все товары по себестоимости
        </div>

        <div class="row">
          <div class="col-12 col-lg-6 mb-3">
            Вы покупаете абсолютно все товары нашего сайта по цене себестоимости, а платите только небольшую фиксированную сумму за доставку и наш сервис (сервисный сбор).
          </div>
          <div class="col-12 col-lg-6">
            <button @click="goToGallery()" class="x-btn">Перейти к каталогу оптовых цен</button>
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

.moto{
  font-size: 20px;
  line-height: 130%;
}


@media screen and (min-width: 992px){
  .moto{
    max-width:850px;
    font-size: 44px;
    line-height: 140%;
  }  
}

</style>