/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.isX = (window.location.href.indexOf('x.bananich.') > -1 || window.location.href.indexOf('neolavka') > -1) ? true : false;

window.Vue = require('vue');
require('./bootstrap');

//Router
import VueRouter from 'vue-router';
import routes from './router.js';
Vue.use(VueRouter);

//Vuex
import Vuex from 'vuex'
import store from './vuex/store.js';
Vue.use(Vuex)

//Juge more Ax
import ax from './juge/juge-more-axios.js';
window.ax = new ax;

//Juge load
import load from './juge/juge-loader.js';
window.load = new load;

//Moment
import moment from 'moment';
window.moment = moment;

//Moment
import cookie from 'js-cookie';
window.Cookies = cookie;

//Toasted
window.terror= function(){console.log('error xzz')};
import Toasted from 'vue-toasted'; 
Vue.use(Toasted);
window.tsuccess = function(){Vue.toasted.global.tsuccess();};

// Infinite scroll
var infiniteScroll = require('vue-infinite-scroll');
Vue.use(infiniteScroll)

//Under construction
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
require('es6-promise').polyfill();

// Components
const files = require.context('./components/__site', true, /\.vue$/i); 
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//File upload
import fileUpload from './components/vendor/file-upload.vue';
Vue.component('file-upload', fileUpload);

//Is json
window.isJson = function(str){try{JSON.parse(str);}catch(e){return false;}return true;}

//Scroll hanler
Vue.directive('scroll', {
    inserted: function (el, binding) {
      let f = function (evt) {
        if (binding.value(evt, el)) {
          window.removeEventListener('scroll', f)
        }
      }
      window.addEventListener('scroll', f)
    }
  })

//Breadcrumbs
import VueBreadcrumbs from 'vue-2-breadcrumbs';
let bcTemplate = {
  template:
    '<ol v-if="$breadcrumbs.length" class="breadcrumb">\n' +
    '    <li class="breadcrumb-item active" aria-current="page">\n' +
    '        <router-link to="/">Главная</router-link>' +
    '    </li>\n' +
    '    <li v-for="(crumb, key) in $breadcrumbs" v-if="crumb.meta.breadcrumb" :key="key" class="breadcrumb-item active" aria-current="page">\n' +
    '        <span v-if="$breadcrumbs.length-1 == key">{{ getBreadcrumb(crumb.meta.breadcrumb) }}</span>' +
    '        <router-link v-else :to="{ path: getPath(crumb) }">{{ getBreadcrumb(crumb.meta.breadcrumb)}}</router-link>' +
    '    </li>\n' +
    '</ol>'
};
// Vue.use(VueBreadcrumbs);
Vue.use(VueBreadcrumbs,bcTemplate);

//Outside clicks
Vue.directive('click-outside', {
  bind: function (el, binding, vnode) {
    el.clickOutsideEvent = function (event) {
      // here I check that click was outside the el and his children
      if (!(el == event.target || el.contains(event.target))) {
        // and if it did, call method provided in attribute value
        vnode.context[binding.expression](event);
      }
    };
    document.body.addEventListener('click', el.clickOutsideEvent)
  },
  unbind: function (el) {
    document.body.removeEventListener('click', el.clickOutsideEvent)
  },
});

window.halloween = false;
window.localServer = (window.location.hostname.indexOf('bananich.loc') > -1) ? true : false;




import TelegramButton from "vue-share-buttons/src/components/TelegramButton";
Vue.component('telegram-button', TelegramButton);
import WhatsApp from "vue-share-buttons/src/components/WhatsAppButton";
Vue.component('whatsapp-button', WhatsApp);
import VkontakteButton from "vue-share-buttons/src/components/VkontakteButton";
Vue.component('vkontakte-button', VkontakteButton);
// Vue.component('twitter-button', TwitterButton);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    store: new Vuex.Store(store),  
});

 
