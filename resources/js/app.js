/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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
window.moment = require('moment');

//Toasted
window.terror= function(){console.log('error xzz')};

// Infinite scroll
var infiniteScroll = require('vue-infinite-scroll');
Vue.use(infiniteScroll)


// Components
const files = require.context('./components/__site', true, /\.vue$/i); 
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    store: new Vuex.Store(store),
});

 
