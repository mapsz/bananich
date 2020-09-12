import jugeVuex from './juge-vuex.js'
import cart from './modules/site/cart'
import user from './modules/site/user'
import category from './modules/site/category'
import settings from './modules/settings'
import favorite from './modules/site/favorite'

let product = new jugeVuex('product');

let store = {  
  modules:{
    cart,user,product,settings,category,favorite
  }
};

export default store;
