<template>
  <div class="footer-container">
    <div class="footer-padding" style="  min-height: calc(100vh - 705px);"></div>
    <footer class="footer pt-3">
      <div class="container">
        <div class="row footer-main">
          <div class="footer-main-tel-soc col-12 col-lg-4 py-2 px-0 border-top border-bottom">
            <div class="d-flex d-lg-block align-items-center justify-content-around">
              <template>
                <div v-if="isX" class="m-0 pb-lg-2 phone"><a :href="'tel:'+settings.x_phone_number">{{settings.x_phone_number}}</a></div>
                <div v-else class="m-0 pb-lg-2 phone"><a :href="'tel:'+settings.phone_number">{{settings.phone_number}}</a></div>
              </template>
              <div class="m-0 footer-soc d-flex ">
                <!-- socials -->
                <template v-if="isX && settings">
                  <!-- instagram -->
                  <a v-if="settings.x_instagram != undefined" :href="settings.x_instagram" target="_blank" class="footer-soc-link">
                    <img src="/image/insta.svg" alt="Мы в instagram">
                  </a>
                  <!-- vkontakte -->
                  <a v-if="settings.x_vkontakte != undefined" :href="settings.x_vkontakte" target="_blank" class="footer-soc-link">
                    <img src="/image/vk.svg" alt="Мы в контакте">
                  </a>
                </template>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div>
              <menu-component :columns="3" :menus="menus" :position="'footer'"></menu-component>
            </div>
          </div>
        </div>
        <hr>
        <div class="row footer-copy">
          <div class="col-lg-5"><div class="footer-copy-left">Предложение не является договором публичной оферты</div></div>
          <div v-if="!isX" class="col-lg-7"><div class="footer-copy-right">Copyright © 2019 Бананыч.рф – Всегда свежие овощи и фрукты по человеческим ценам.</div></div>
          <div v-else class="col-lg-7"><div class="footer-copy-right">Copyright © 2021 Neolavka – Всегда свежие овощи и фрукты по человеческим ценам.</div></div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    isX:isX,
  }},
  computed:{
    ...mapGetters({
      menus:'page/get',
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