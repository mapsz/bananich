/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
require('./bootstrap');

//Font Awsome
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
window.library = library; 
import { faArrowLeft, faHighlighter } from '@fortawesome/free-solid-svg-icons';
library.add(faArrowLeft);
import { faArrowRight } from '@fortawesome/free-solid-svg-icons';
library.add(faArrowRight);
import { faTimes } from '@fortawesome/free-solid-svg-icons';
library.add(faTimes);
import { faCheck } from '@fortawesome/free-solid-svg-icons';
library.add(faCheck);
import { faBoxOpen } from '@fortawesome/free-solid-svg-icons';
library.add(faBoxOpen);
import { faBars } from '@fortawesome/free-solid-svg-icons';
library.add(faBars);
import { faCheckSquare } from '@fortawesome/free-solid-svg-icons';
library.add(faCheckSquare);
import { faEdit } from '@fortawesome/free-solid-svg-icons';
library.add(faEdit);
import { faTrashAlt } from '@fortawesome/free-solid-svg-icons';
library.add(faTrashAlt);
import { faCode } from '@fortawesome/free-solid-svg-icons';
library.add(faCode);
import { faCommentAlt } from '@fortawesome/free-solid-svg-icons';
library.add(faCommentAlt);
import { faList } from '@fortawesome/free-solid-svg-icons';
library.add(faList);
import { faCog } from '@fortawesome/free-solid-svg-icons';
library.add(faCog);
{/* <font-awesome-icon icon="check" /> */}
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.config.productionTip = false;

//Router
import VueRouter from 'vue-router';
import routes from './router.js';
Vue.use(VueRouter);

//Vuex
import Vuex from 'vuex'
import store from './vuex/adminStore.js';
Vue.use(Vuex)

//Juge more Ax
import ax from './juge/juge-more-axios.js';
window.ax = new ax;

//Juge load
import load from './juge/juge-loader.js';
window.load = new load;

//Moment
window.moment = require('moment');

// Input spinner
window.inputSpinner = require('bootstrap-touchspin');

//Date picker
import VueFlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
Vue.use(VueFlatPickr);
window.datePickerConfig = {
  dateFormat: 'd.m.Y',
}

//Switch checkbox
import { ToggleButton } from 'vue-js-toggle-button' 
Vue.component('ToggleButton', ToggleButton)

//Toasted
import Toasted from 'vue-toasted'; 
Vue.use(Toasted);
Vue.toasted.register(
  'terror', 
  'Oops.. Something Went Wrong..', {
  type : 'error',
  position:'bottom-center',
});
window.terror= function(){Vue.toasted.global.terror();};


//Cropperjs
import 'cropperjs/dist/cropper.css';
import Cropper from 'cropperjs';
window.Cropper = Cropper;


//Loader
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Vue from 'vue';
Vue.use(Loading,{
  backgroundColor:'#fefee5',
},{
  //
});

// Mixins
import jugeAx from './mixins/juge-axios.vue';
import vueLoading from 'vue-loading-overlay';
Vue.mixin(jugeAx);

// Components
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

window.currency = 'в‚Ѕ';

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    mixins: [jugeAx],
    store: new Vuex.Store(store),
});

 
