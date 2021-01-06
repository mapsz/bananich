let routes = [];

//__site

  //Interview
  // import interview from './components/interview/interview.vue';
  // routes.push(
  //   {path: '/interview',    component:interview},
  // );

  //Welcome
  import welcome from './components/__site/welcome/welcome.vue';
  routes.push(
    {path: '/welcome',    component:welcome, name:'welcome'},
  );

  //Shared Order
  import sharedOrder from './components/__site/shared-order/shared-order.vue';
  import sharedOrderOpen from './components/__site/shared-order/open/shared-order-open.vue';
  import sharedOrderCheckout from './components/__site/shared-order/checkout/shared-order-checkout.vue';
  routes.push(
    {path: '/shared/order',                         component:sharedOrderOpen},
    {path: '/shared/order/edit/:order_link',        component:sharedOrderOpen},
    {path: '/shared/order/open',                    component:sharedOrderOpen},
    {path: '/shared/order/:order_link',             component:sharedOrder, name:'sharedOrder'},
    {path: '/shared/order/checkout/:order_link',    component:sharedOrderCheckout},
  );

  //Catalogue 
  import siteProducts from './components/__site/products/products.vue';
  routes.push(
    {path: '/category/:cat_id',    component:siteProducts},
    {path: '/category/:parent_cat_id/category/:cat_id',    component:siteProducts},
    {path: '/catalogue',    component:siteProducts},
    {path: '/discounts',    component:siteProducts,},
    {path: '/',    component:siteProducts,},
  );

  //Profile
  import siteProfile from './components/__site/profile/profile.vue';
  import siteProfilePersonalData from './components/__site/profile/personal-data/personal-data.vue';
  import siteProfileFavorites from './components/__site/profile/favorites/favorites.vue';
  import siteProfileBonus from './components/__site/profile/bonus/bonus.vue';
  import siteProfileOrders from './components/__site/profile/orders/orders.vue';
  
  import siteProfilesharedOrder from './components/__site/profile/shared-orders/profile-shared-orders.vue';
  
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
        {
          path: '/profile/shared/orders', component:siteProfilesharedOrder,
          name: 'Мои закупки', meta: {breadcrumb: 'Мои закупки'}
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
  routes.push(
    {path: '/category/:catId/product/:id',    component:siteProduct},
    {path: '/category/:parent_cat_id/category/:catId/product/:id',    component:siteProduct},
    {path: '/discounts/product/:id',    component:siteProduct},
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

//DRIVER
  let driverPrefix = '/driver';

  //driver
  // import driver from './components/driver/driver.vue';
  // routes.push(
  //   {path: driverPrefix,    component:driver},
  // );


//ADMIN
  let adminPrefix = '/admin';

  
  // //Mailing
  // import mailing from './components/mailings/mailing.vue';
  // routes.push(
  //   {path: adminPrefix+'/mailing/:id',component: mailing},
  //   {path: adminPrefix+'/mailing',component: mailing},
  //   {path: adminPrefix+'/mailings',component: mailings},
  // );

  //Libras
  import libras from './components/libras/libras.vue';
  routes.push(
    {path: adminPrefix+'/libras',component: libras},
  );

  //Mailing
  import emails from './components/mailings/emails/emails.vue';
  import email from './components/mailings/emails/email.vue';
  routes.push(
    {path: adminPrefix+'/email/:id',component: email},
    {path: adminPrefix+'/email',component: email},
    {path: adminPrefix+'/emails',component: emails},
  );

  //Delivery
  import deliveries from './components/driver/delivery/deliveries.vue';
  import delivery from './components/driver/delivery/delivery.vue';
  routes.push(
    {path: adminPrefix+'/delivery/:id',component: delivery},
    {path: adminPrefix+'/deliveries',component: deliveries},
    {path: adminPrefix+'/deliveries/:drivers',component: deliveries},
  );  

  //Not Found
  import notFound from './components/not-found/not-founds.vue';
  routes.push(
    {path: adminPrefix+'/not/founds',component: notFound},
  );  

  //categories
  import categories from './components/categories/categories.vue';
  import category   from './components/categories/category.vue';
  routes.push(
    {path: adminPrefix+'/categories',    component:categories},
    {path: adminPrefix+'/category/:id',    component:category},
    {path: adminPrefix+'/category/:catId/category/:id',    component:category},
  );


  //coupons
  import coupons from './components/coupons/coupons.vue';
  routes.push(
    {path: adminPrefix+'/coupons',    component:coupons},
  );

  //settings
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
  import orderTermobox from './components/orders/orders-termobox.vue';
  routes.push(
    {path: adminPrefix+'/orders/termobox',      component:orderTermobox},
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

  //Logistics
  import logistics from './components/logistics/logistics.vue';
  routes.push(
    {path: adminPrefix+'/orders/logistics',           component:logistics},
  );

  //Pages
  import page from './components/pages/page.vue';
  import pages from './components/pages/pages.vue';
  import pageAdd from './components/pages/_partials/page-add.vue';
  routes.push(
    {path: adminPrefix+'/pages',           component:pages},
    {path: adminPrefix+'/page/add',           component:pageAdd},
    {path: adminPrefix+'/page/:id',           component:page},
  );  

  //Menus
  import menu from './components/pages/menus/menus.vue';
  import menuAdd from './components/pages/_partials/page-add.vue';
  routes.push(
    {path: adminPrefix+'/menus',           component:menu},
    {path: adminPrefix+'/menu/add',        component:menuAdd},
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
  import user from './components/users/user.vue';
  routes.push(
    {path: adminPrefix+'/users',component: users},
    {path: adminPrefix+'/user/:id',component: user},
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
    {path: '/gruzka/strews',component: strews},
  );

  //Statistics  
  import statistics from './components/statistics/statistics.vue';
  routes.push(
    {path: adminPrefix+'/statistics',component: statistics},
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


  //Delivery
  routes.push(
    {path: driverPrefix+'/delivery/:id',component: delivery},
    {path: driverPrefix+'/deliveries',component: deliveries},
    {path: driverPrefix+'',component: deliveries},
  );  

  //Gruzka
  import gruzka from './components/gruzka/gruzka.vue';
  import gruzkas from './components/gruzka/gruzkas.vue';
  routes.push(
    {path: '/gruzka/:id',    component: gruzka},
    {path: '/gruzka',        component: gruzkas},
    {path: '/admin/gruzkas',        component: gruzkas},
    {path: '/admin/gruzkas',        component: gruzkas},
  );

  ///^^ Admin


  //404
  import site404 from './components/__site/404/v-404.vue';
  routes.push(
    {
      path: '/404', 
      component: site404
    },
  );
  
  //Pages
  import sitePage from './components/__site/pages/page.vue';
  routes.push(
    {
      path: '*', 
      component: sitePage
    },
  );


export default {
    'mode':'history',
    'routes':routes
}