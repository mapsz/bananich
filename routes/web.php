<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// */

// Route::get('/mail', function(){

//   Mail::send('mail', ['name' => 'dataname'], function($m){
//     $m->to('mapss@inbox.lv','to');
//     $m->from('no-reply@bananich.ru');
//   });

//   return view('mail');
// });


Route::group(['middleware' => 'under-construction'], function () {

    
  Route::get('/home', function(){
    return redirect('/');
  });

  Route::get('/test/test', function(){
      //
  });

  //Order
  Route::put('/order/put', 'OrderController@put');

  //Cart
  Route::get('/json/cart', 'CartController@get');
  Route::post('/cart/edit/item', 'CartController@editItem');
  Route::delete('/cart/remove/item', 'CartController@removeItem'); 
  Route::delete('/cart/reset', 'CartController@resetItems');

  //Session
  Route::get('/json/session', 'SessionController@get');

  //Categories
  Route::get('/json/categories', 'CategoryController@getAll');

  //Interview
  Route::get('/interview/{id}', function($id){
      return view('interview',['id' => $id]);
  });
  Route::put('/put/interviews', 'InterviewController@put');

  //SMS
  Route::get('/sms/to/send', 'SmsController@toSend');
  Route::get('/sms/send/confirm', 'SmsController@sendConfirm');
  Route::get('/sms/add/send', 'SmsController@sendAdd');

  //Errors
  Route::put('/error', 'ErrorController@put');

  //Auth
  Auth::routes();

  //User
  Route::get('/auth/user', 'UserController@getAuthUser');
  Route::post('/user', 'UserController@post');
  Route::post('/user/address', 'UserController@postAddress');

  //Present
  Route::get('/present/settings', 'PresentController@getSettings'); 
  Route::get('/product/present', 'PresentController@getProduct'); 
  Route::put('/present/cart', 'PresentController@addPresentToCart'); 

  //Settings
  Route::get('/json/settings', 'SettingController@get'); 

  //Order Limits
  Route::get('/order/available/days', 'OrderController@getAvailableDays');

  //Not found
  Route::put('/not/found', 'NotFoundController@put'); 

  //Admin
  Route::group(['middleware' => ['auth', 'can:admin panel']], function (){

    
    //Menus\Pages
    Route::put('/page', 'PageController@put');
    Route::post('/page', 'PageController@post');
    Route::post('/page/menu/attach', 'PageController@attach');
    Route::put('/menu', 'MenuController@put');

    //Coupons
    Route::post('/coupon', 'CouponController@post');
    Route::put('/coupon', 'CouponController@put');
    // Route::get('/order/limit/settings', 'OrderController@getLimitSettings');

    //Order Limits
    Route::get('/orders/calendar', 'OrderController@getCalendarOrders');
    Route::get('/order/limit/settings', 'OrderController@getLimitSettings');

    //Category
    Route::put('/category', 'CategoryController@put');
    Route::post('/category', 'CategoryController@post');
    Route::post('/categoty/main/photo', 'CategoryController@editMainPhoto');
    Route::post('/category/product/detach', 'CategoryController@detachProduct');
    Route::post('/category/product/attach', 'CategoryController@attachProduct');
    Route::post('/category/category/detach', 'CategoryController@detachCategory');
    Route::post('/category/category/attach', 'CategoryController@attachCategory');
    
    //Settings
    Route::post('/settings', 'SettingController@post');  

    //Present
    Route::put('/admin/product/present', 'PresentController@putProduct'); 
    Route::delete('/admin/product/present', 'PresentController@deleteProduct'); 

    //File upload
    Route::post('/file/upload', 'FileUploadController@fileUpload');
    Route::delete('/file/delete', 'FileUploadController@fileDelete');


    //Admin panel
    Route::prefix('admin')->group(function (){
      //Vue
      Route::get('/{vue_capture?}', function () {
          return view('admin');
      })->where('vue_capture', '[\/\w\.-]*');    
    });

    //Juge CRUD
    Route::middleware([])->group(function (){
      Route::get('/juge', 'JugeCRUDController@get');
      Route::get('/juge/keys', 'JugeCRUDController@getKeys');
      Route::get('/juge/inputs', 'JugeCRUDController@getInputs');    
    });

    //Order
    Route::middleware([])->group(function (){
      //Order
      Route::get('/json/orders', 'OrderController@jsonGet');
      Route::post('/order', 'OrderController@post');
      Route::put('/order/item', 'OrderController@addItem');

      //Order Status
      Route::get('/json/order/statuses', 'OrderStatusController@jsonGetStatuses');
      Route::put('/order/status', 'OrderStatusController@putStatus');  
    });

    //Product
    Route::middleware([])->group(function (){
      Route::put('/product', 'ProductController@put');
      Route::post('/product', 'ProductController@post');
      Route::get('/json/products', 'ProductController@get');
      Route::get('/base64/preloaded/images', 'ProductController@getBase64PreloadedImages');

      //Product Published
      Route::post('/product/publish', 'ProductController@publish');

      //Delivery days
      Route::post('/product/delivery/days', 'ProductController@editDeliveryDays');

      //Main photo
      Route::post('/product/main/photo', 'ProductController@editMainPhoto');
      
      //Config List
      Route::get('/config', 'ListConfigController@get');
      Route::post('/config/post', 'ListConfigController@post');

      //Product discount
      Route::post('/product/discount/set', 'ProductController@setDiscount');
      Route::delete('/product/discount/remove', 'ProductController@removeDiscount');

      //Discount
      Route::delete('/discount/remove', 'DiscountController@remove');
      Route::put('/discount/add', 'DiscountController@add');
    });

    //Report
    Route::middleware([])->group(function (){

      //Report
      Route::get('/json/report', 'ReportController@jsonGet');

      //Stocktaking
      Route::get('/json/stocktaking/products', 'StocktakingController@jsonGetProducts');
      Route::put('/stocktaking', 'StocktakingController@put');

      //Writeoff        
      Route::put('/put/writeoff', 'WriteoffController@put');    

      //Purchases        
      Route::put('/put/purchase', 'PurchaseController@put');      
      //Purchase prices       
      Route::get('/json/purchase/prices', 'PurchaseController@getPrices');
      Route::put('/put/purchase/prices', 'PurchaseController@putPrice');

      //Goods
      Route::get('/json/goods', 'GoodsController@jsonGet');
      Route::put('/put/goods', 'GoodsController@put');
      Route::post('/post/goods', 'GoodsController@post');
      Route::delete('/delete/goods', 'GoodsController@delete');

    });


    //Supplier
    Route::get('/json/suppliers', 'SupplierController@jsonGet');
    Route::get('/json/suppliers/distinct', 'SupplierController@jsonDistinct');
    Route::put('/put/supplier', 'SupplierController@put');
    Route::post('/post/supplier', 'SupplierController@post');
    Route::delete('/delete/supplier', 'SupplierController@delete');
    Route::put('/attach/supplier/product', 'SupplierController@addProduct');
    Route::delete('/remove/supplier/product', 'SupplierController@removeProduct');
    Route::post('/edit/supplier/product/id', 'SupplierController@editId');



  });

  //Site
  Route::group(['middleware' => []], function (){


    //Favorites
    Route::put('/favorite', 'FavoriteController@put');
    Route::delete('/favorite', 'FavoriteController@remove');

    //Pages
    Route::middleware([])->group(function (){
      //Profile
      Route::middleware(['auth'])->get('/profile', function () {
        return view('main');
      })->where('vue_capture', '[\/\w\.-]*');
    });

    //Vue Pages
    Route::get('/{vue_capture?}', function () {
        return view('main');
    })->where('vue_capture', '[\/\w\.-]*');

    //Juge READ
    Route::middleware([])->group(function (){
      Route::get('/juge', 'JugeCRUDController@get');
      Route::get('/juge/keys', 'JugeCRUDController@getKeys');
      Route::get('/juge/inputs', 'JugeCRUDController@getInputs');    
    });

  });


      

  Route::get('/404', function(){
      abort(404);
  });


  //Old admin
  do{
    //Admin
    // Route::middleware(['can:admin panel'])->prefix('admin')->group(function (){

    //     //Settings
    //     Route::post('/settings', 'SettingController@post');  

    //     //Return Item
    //     Route::put('/return/item', 'ReturnItemController@put');      
    //     Route::delete('/return/item', 'ReturnItemController@delete');      

    //     //Confirm
    //     Route::get('/to/confirm/orders', 'OrderController@getToConfirmOrders');

    //     //Pay
    //     Route::get('/json/pay/methods', 'PayController@getMethods');

    //     //Delivery    
    //     Route::get('/json/deliveries', 'DeliveryController@jsonGet');  
    //     Route::put('/put/delivery', 'DeliveryController@put');      
    //     Route::delete('/delivery', 'DeliveryController@delete');      

    //     //Statistics
    //     Route::get('/json/statistics', 'StatisticController@jsonGet');



    //     //Gruzka
    //     Route::put('/gruzka/confirm', 'GruzkaController@confirm');
    //     Route::put('/gruzka/noitem', 'GruzkaController@noItem');
    //     Route::put('/gruzka/done', 'GruzkaController@done');

    //     //Permissions
    //     // Route::get('/', 'PermissionController@redirect');

    //     //User
    //     Route::put('/user', 'UserController@put');
    //     Route::get('/json/users', 'UserController@jsonGet');
    //     Route::post('/user/comment', 'UserController@post');

    //     //Auto gruzka
    //     Route::get('/gruzka/auto/order', 'OrderController@autoOrder');

    //     //Item quantity update
    //     Route::post('/item/quantity', 'ItemController@quantityUpdate');
    //     Route::put('/item/status', 'ItemStatusController@putStatus');

    //     //Parse
    //     Route::get('/parse/orders', 'ParseController@getOrders');
    //     Route::get('/parse/product/by/name', 'ParseController@parseProductByName');

    //     //Order
    //     Route::get('/json/orders', 'OrderController@jsonGet');
    //     Route::post('/order', 'OrderController@post');
    //     Route::put('/order/item', 'OrderController@addItem');

    //     //Order Status
    //     Route::get('/json/order/statuses', 'OrderStatusController@jsonGetStatuses');
    //     Route::put('/order/status', 'OrderStatusController@putStatus');

    //     //Item
    //     Route::get('/json/item/statuses', 'ItemStatusController@jsonGetStatuses');
    //     Route::delete('/item', 'ItemController@delete');
    //     Route::post('/item', 'ItemController@post');

    //     //Container
    //     Route::put('/container', 'ContainerController@put');
    //     Route::delete('/container', 'ContainerController@delete');
    //     Route::get('/json/containers', 'ContainerController@jsonGet');
    //     Route::put('/container/attach', 'ContainerController@attach');
        
    //     //File upload
    //     Route::post('/file/upload', 'FileUploadController@fileUpload');
    //     Route::delete('/file/delete', 'FileUploadController@fileDelete');

    //     // Route::get('/home', function(){
    //     //     return view('main');
    //     // })->name('home');

    //     //Juge CRUD
    //     Route::get('/juge', 'JugeCRUDController@get');
    //     Route::get('/juge/keys', 'JugeCRUDController@getKeys');
    //     Route::get('/juge/inputs', 'JugeCRUDController@getInputs');

    //     Route::get('/{vue_capture?}', function () {
    //         return view('admin');
    //     })->where('vue_capture', '[\/\w\.-]*');

    // });

  }while(0);

  Auth::routes();



});
