import testtest from './components/testtest.vue';
//Orders
import orderList from './components/orders/orders.vue';
import order from './components/orders/order.vue';
import orderCall from './components/gruzka/order-call.vue';
import call from './components/gruzka/call.vue';
import orderGruzka from './components/gruzka/order-gruzka.vue';
import gruzka from './components/gruzka/gruzka.vue';
import confirmList from './components/gruzka/confirm/confirm-list.vue';
import confirmOrder from './components/gruzka/confirm/confirm-order.vue';
import container from './components/gruzka/container/container.vue';
import products from './components/products/products.vue';
import product from './components/products/product.vue';
import productAdd from './components/products/product.vue';
import users from './components/users/users.vue';
import usersAdd from './components/users/partials/user-add.vue';
import items from './components/items/items-list.vue';
import itemsParvin from './components/items/items-parvin.vue';
import strews from './components/strews/strews-list.vue';
import statistics from './components/statistics/statistics-list.vue';
//Report
import report from './components/report/report/report.vue';
import suppliers from './components/report/suppliers/suppliers.vue';
import supplier from './components/report/suppliers/supplier.vue';
import purchases from './components/report/purchase/purchases.vue';
import purchasePirces from './components/report/purchase/prices/purchase-prices.vue';
import writeoff from './components/report/writeoff/writeoff.vue';
import stocktaking from './components/report/stocktaking/stocktaking.vue';

//Delivery
import deliveries from './components/delivery/deliveries.vue';
import delivery from './components/delivery/delivery.vue';


export default {

  mode:'history',
  routes:[  
    //testtest
    {
      path:'/testtest',
      component: testtest,
    }, 
    //Deliveries
    {
      path:'/deliveries',
      component: deliveries,
    }, 
    {
      path:'/delivery/:id',
      component: delivery,
    }, 
    //Report
    {
      path:'/report',
      component: report,
    }, 
    //Supplier
    {
      path:'/report/supplier/:id',
      component: supplier,
    },   
    //Suppliers
    {
      path:'/report/suppliers',
      component: suppliers,
    },     
    //Purchase
    {
      path:'/report/purchases',
      component: purchases,
    },     
    //Purchase prices
    {
      path:'/report/purchase/prices',
      component: purchasePirces,
    },  
    //writeoff
    {
      path:'/report/writeoff',
      component: writeoff,
    }, 
    //stocktaking
    {
      path:'/report/stocktaking',
      component: stocktaking,
    }, 
    //Statistics   
    {
      path:'/statistics',
      component: statistics,
    }, 
    //Strews   
    {
      path:'/strews',
      component: strews,
    },     
    //Items
    {
      path:'/report/items',
      component: items,
    }, 
    {
      path:'/zakupka',
      component: itemsParvin,
    }, 
    //Users
    {
      path:'/user/add',
      component: usersAdd,
    },    
    {
      path:'/users',
      component: users,
    },    
    //Products
    {
      path:'/products-list',
      component: products,
    }, 
    {
      name:"product",
      path:'/product/:id',
      component: product,
    }, 
    {
      name:"product-add",
      path:'/product/add',
      component: productAdd,
    }, 
    {
      path:'/containers',
      component: container,
    }, 
    {
      path:'/confirm',
      component: confirmList,
    },  
    {
      path:'/confirm/order/:id',
      component: confirmOrder,
    },  
    {
      path:'/',
      component: orderList,
      // component: main,
    },
    {
      path:'/main',
      component: orderList,
      // component: main,
    },
    {
      path:'/order-list',
      component: orderList,
    },
    {
      path:'/order/:id',
      component: order,
    },
    {
      path:'/call/order/:id',
      component: orderCall,
    },
    {
      path:'/call/order',
      component: orderCall,
    },
    {
      path:'/call',
      component: call,
    },
    {
      path:'/gruzka/order',
      component: orderGruzka,
    },
    {
      path:'/gruzka/order/:id',
      component: orderGruzka,
    },
    {
      path:'/gruzka',
      component: gruzka,
    },
  ]

}