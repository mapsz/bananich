import jugeVuex from './juge-vuex.js'
import cart from './modules/site/cart'
import user from './modules/site/user'
import category from './modules/site/category'
import settings from './modules/settings'
import favorite from './modules/site/favorite'
import checkout from './modules/site/checkout'
import presents from './modules/site/presents'
import orderLimits from './modules/orderLimits'
import sharedOrder from './modules/site/sharedOrder'
import addresses from './modules/site/addresses'

let product = new jugeVuex('product');
let order = new jugeVuex('order');
let bonus = new jugeVuex('bonus');
let menu = new jugeVuex('menu');
let page = new jugeVuex('page');

let store = {  
  modules:{
    cart,user,product,settings,category,favorite,order,checkout,bonus,presents,orderLimits,menu,page,sharedOrder,addresses
  }
};

export default store;
