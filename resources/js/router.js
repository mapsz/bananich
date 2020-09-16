let routes = [];

// import testtest from './components/testtest.vue';
// routes.push(
//   {path: '/testtest',    component:testtest},
// );

//__site

  //Catalogue 
  import siteProducts from './components/__site/products/products.vue';
  routes.push(
    {path: '/category/:id',    component:siteProducts},
    {path: '/catalogue',    component:siteProducts},
    {path: '/',    component:siteProducts,},
  );

  //Profile
  import siteProfile from './components/__site/profile/profile.vue';
  import siteProfilePersonalData from './components/__site/profile/personal-data/personal-data.vue';
  import siteProfileFavorites from './components/__site/profile/favorites/favorites.vue';
  import siteProfileBonus from './components/__site/profile/bonus/bonus.vue';
  import siteProfileOrders from './components/__site/profile/orders/orders.vue';
  routes.push(
    {      
      path: '/profile',component:siteProfile,
      meta: { breadcrumb: 'Профиль'},
      children: [
        {
          path: '', component:siteProfilePersonalData,
          name: 'Личные данные',meta: {breadcrumb: 'Личные данные'}
        },
        {
          path: 'favorites', component:siteProfileFavorites,
          name: 'Избранное',meta: {breadcrumb: 'Избранное'}
        },
        {
          path: '/profile/bonus',    component:siteProfileBonus,
          name: 'Бонусы', meta: {breadcrumb: 'Бонусы'}
        },
        {
          path: '/profile/orders',    component:siteProfileOrders,
          name: 'Мои заказы', meta: {breadcrumb: 'Мои заказы'}
        },
      ]
    }
  );



  //Order thanks
  import siteOrderThanks from './components/__site/order-thanks/order-thanks.vue';
  routes.push(
    {path: '/order-thanks',    component:siteOrderThanks},
  );


  //Confirmation
  import siteConfirmation from './components/__site/confirmation/confirmation.vue';
  routes.push(
    {path: '/confirmation',    component:siteConfirmation},
  );

  //Presents
  import sitePresents from './components/__site/presents/presents.vue';
  routes.push(
    {path: '/presents',    component:sitePresents},
  );

  //Product
  import siteProduct from './components/__site/products/product.vue';
  routes.push(
    {path: '/product/:id',    component:siteProduct},
  );

  //Cart
  import siteCart from './components/__site/cart/cart.vue';
  routes.push(
    {path: '/cart',    component:siteCart},
  );

  //Checkout
  import siteCheckout from './components/__site/checkout/checkout.vue';
  routes.push(
    {path: '/checkout',    component:siteCheckout},
  );


//ADMIN
  let adminPrefix = '/admin';

  ///categories
  import categories from './components/categories/categories.vue';
  import category   from './components/categories/category.vue';
  routes.push(
    {path: adminPrefix+'/categories',    component:categories},
    {path: adminPrefix+'/category/:id',    component:category},
  );


  ///settings
  import settings from './components/settings/settings.vue';
  routes.push(
    {path: adminPrefix+'/settings',    component:settings},
  );

  //Presents
  import presents from './components/presents/presents.vue';
  routes.push(
    {path: adminPrefix+'/presents',    component:presents},
  );

  //Orders
  import order from './components/orders/order.vue';
  import orders from './components/orders/orders.vue';
  routes.push(
    {path: adminPrefix+'/order/:id',           component:order},
    {path: adminPrefix+'/orders',              component:orders},
    {path: adminPrefix+'/main',                component:orders},
    {path: adminPrefix+'/',                    component:orders},
  );

  //Orders Limit
  import orderLimit from './components/orders-limit/orders-limit.vue';
  routes.push(
    {path: adminPrefix+'/orders/limits',           component:orderLimit},
  );

  //Sms
  import sms from './components/sms/sms.vue';
  routes.push(
    {path: adminPrefix+'/sms',    component:sms},
  );

  //Interview
  import interview from './components/interview/interviews.vue';
  routes.push(
    {path: adminPrefix+'/interviews',    component:interview},
  );

  //Bonus
  import bonuses from './components/bonuses/bonuses.vue';
  routes.push(
    {path: adminPrefix+'/bonuses',    component:bonuses},
  );

  //Gruzka
  import gruzka from './components/gruzka/gruzka.vue';
  import gruzkas from './components/gruzka/gruzkas.vue';
  routes.push(
    {path: adminPrefix+'/gruzka/:id',    component: gruzka},
    {path: adminPrefix+'/gruzkas',       component: gruzkas},
  );

  //Confirms
  import confirms from './components/confirm/confirms.vue';
  import confirm from './components/confirm/confirm.vue';
  routes.push(
    {path: adminPrefix+'/confirms',component: confirms,},  
    {path: adminPrefix+'/confirm/:id',component: confirm,},
  )
  //Container
  import containers from './components/containers/containers.vue';
  routes.push(
    {path: adminPrefix+'/containers',component: containers},
  );

  //Products
  import products from './components/products/products.vue';
  import product from './components/products/product.vue';
  routes.push(
    {path: adminPrefix+'/products',component: products,}, 
    {path: adminPrefix+'/product/:id',component: product,name:"product"},  
  );

  //User
  import users from './components/users/users.vue';
  routes.push(
    {path: adminPrefix+'/users',component: users},
  );

  //Items
  import items from './components/items/items.vue';
  import itemsParvin from './components/items/items-parvin.vue';
  routes.push(
    {path: adminPrefix+'/report/items',component: items},
    {path: adminPrefix+'/zakupka',component: itemsParvin},
  );
    
  //Strews
  import strews from './components/strews/strews.vue';
  routes.push(
    {path: adminPrefix+'/strews',component: strews},
  );

  //Statistics  
  import statistics from './components/statistics/statistics.vue';
  routes.push(
    {path: adminPrefix+'/statistics',component: statistics},
  );

  //Delivery
  import deliveries from './components/delivery/deliveries.vue';
  import delivery from './components/delivery/delivery.vue';
  routes.push(
    {path: adminPrefix+'/delivery/:id',component: delivery},
    {path: adminPrefix+'/deliveries',component: deliveries},
  );

  //Report
  import reports from './components/report/report/reports.vue';
  routes.push(
    {path: adminPrefix+'/reports',component: reports},
  );

  //Suppliers
  import supplier from './components/report/suppliers/supplier.vue';
  import suppliers from './components/report/suppliers/suppliers.vue';
  routes.push(
    {path: adminPrefix+'/report/supplier/:id',component: supplier},
    {path: adminPrefix+'/report/suppliers',component: suppliers},
  );  

  //Purchases
  import purchases from './components/report/purchase/purchases.vue';
  import purchasePirces from './components/report/purchase/prices/purchase-prices.vue';
  routes.push(
    {path: adminPrefix+'/report/purchases',component: purchases},
    {path: adminPrefix+'/report/purchase/prices',component: purchasePirces},
  );  
  
  //Writeoff
  import writeoff from './components/report/writeoff/writeoff.vue';
  routes.push(
    {path: adminPrefix+'/report/writeoff',component: writeoff},
  );

  //Stocktaking
  import stocktaking from './components/report/stocktaking/stocktaking.vue';
  routes.push(
    {path: adminPrefix+'/report/stocktaking',component: stocktaking},
  );


export default {
    'mode':'history',
    'routes':routes
}