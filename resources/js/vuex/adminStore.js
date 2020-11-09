import jugeVuex from './juge-vuex.js'

import delivery from './modules/delivery'
import order from './modules/order'
import user from './modules/user'
import product from './modules/product'
import settings from './modules/settings'
import orderLimits from './modules/orderLimits'
// import statistic from './modules/statistic'


let confirm = new jugeVuex('confirm');
// let product = new jugeVuex('product');
let report = new jugeVuex('report');
let item = new jugeVuex('item');
let supplier = new jugeVuex('supplier');
let stocktaking = new jugeVuex('stocktaking');
let purchase = new jugeVuex('purchase');
let writeoff = new jugeVuex('writeoff');
let statistic = new jugeVuex('statistic');
let purchasePrice = new jugeVuex('purchasePrice');
let bonus = new jugeVuex('bonus');
let sms = new jugeVuex('sms');
let interview = new jugeVuex('interview');
let category = new jugeVuex('category');
let page = new jugeVuex('page');
let menu = new jugeVuex('menu');
let coupon = new jugeVuex('coupon',true,true);
let logistic = new jugeVuex('logistic');
let notFound = new jugeVuex('notFound');
let email = new jugeVuex('email');
let libra = new jugeVuex('libra',true,true);
// let user = new jugeVuex('user');

let store = {  
  modules:{
    order,delivery,confirm,report,product,item,supplier,stocktaking,
    purchase,writeoff,statistic,purchasePrice,bonus,user,sms,interview,
    settings,category,orderLimits,page,menu,coupon,logistic,notFound,email,libra
  }
};

export default store;
