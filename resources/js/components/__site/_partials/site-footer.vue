<template>
  <div class="footer-container">
    <div class="footer-padding" style="  min-height: calc(100vh - 705px);"></div>
    <footer class="footer pt-3">
      <div class="container">
        <div class="row footer-main">
          <div class="footer-main-tel-soc col-12 col-lg-4 py-2 px-0 border-top border-bottom">
            <div class="d-flex d-lg-block align-items-center justify-content-around">
              <div class="m-0 pb-lg-2 phone"><a :href="'tel:'+settings.phone_number">{{settings.phone_number}}</a></div>
              <div class="m-0 footer-soc d-flex ">
                <a href="https://instagram.com/bananich.ru" target="_blank" class="footer-soc-link"><img src="/image/insta.svg" alt="Мы в instagram"></a>
                <a href="https://vk.com/bananichru" target="_blank" class="footer-soc-link"><img src="/image/vk.svg" alt="Мы в контакте"></a>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div>
              <menu-component :columns="3" :menus="menus"></menu-component>
            </div>
          </div>
        </div>
        <hr>
        <div class="row footer-copy">
          <div class="col-lg-5"><div class="footer-copy-left">Предложение не является договором публичной оферты</div></div>
          <div class="col-lg-7"><div class="footer-copy-right">Copyright © 2019 Бананыч.рф – Всегда свежие овощи и фрукты по человеческим ценам.</div></div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {

  computed:{
    ...mapGetters({
      menus:'menu/get',
      settings:'settings/beautyGet',
    }),    
  },   
}
</script>

<style>
  @media screen and (min-width: 992px) {
    .footer-main-tel-soc{
      border:0px !important;
    }
  }
</style>