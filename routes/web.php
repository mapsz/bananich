<?php


{//DEBUG

  Route::get('/debug/zzz', function(){


    echo 'Здесь происходит, что-то очень важное 🎩🎩';
  });


  {//Mail test
    Route::get('/mail/test/preview', function(){

      $order = App\Order::getWithOptions(['id'=>2104184755]);

      // $order = $order->toArray();


      // dd($order->toarray());

      return view('mail.mailOrder', ['order' => $order->toarray(),'site' => 'x']);

      // $user = App\User::find(751);
      // $email = App\Email::jugeGet(['id'=>$id]);
      // $html = App\Email::customTags($email->html,$user);

      
      // return view('mail.customEmail', ['user' => $user->toarray(),'html' => $html]);


      // $order = App\Order::getWithOptions(['id'=>$id]);


      // return view('mail.mailOrder', ['order' => $order, 'site' => 'x']);
  
    
    //   // $order = App\Order::getWithOptions(['id'=>$id]);
    
    //   // dump(  $order->toarray());
    
    //   // $user = App\User::find(751);
    //   // $email = App\Email::jugeGet(['id'=>$id]);
    
    //   // $html = App\Email::customTags($email->html,$user);
    
    //   // dump($html);
    
    
    //   // Mail::send('mail.customEmail', ['user' => $user->toarray(),'html' => $html], function($m){
    //   //   // $m->to('aslanovadaria@yandex.ru','to');
    //   //   // $m->to('mapss@inbox.lv','to');
    //   //   $m->to('jurijsgergelaba@yandex.ru','to');
    //   //   $m->from('no-reply@bananich.ru');
    //   //   $m->subject('Дегустационный сет от Бананыча');
    //   // });
    
    //   // Mail::send('mail.customEmail', ['user' => $user->toarray(),'html' => $html], function($m){
    //   //   $m->to('aslanovadaria@yandex.ru','to');
    //   //   // $m->to('mapss@inbox.lv','to');
    //   //   // $m->to('jurijsgergelaba@yandex.ru','to');
    //   //   $m->from('no-reply@bananich.ru');
    //   //   $m->subject('Дегустационный сет от Бананыча');
    //   // });
    
    
    //   // return view('mail.test');
    });
  }

}

{//Libras
  Route::get('/vesi', 'LibraController@list');
}

{// Prise List
  Route::get('/price/list/yandex',    'PriceListController@getYandex');
}

{//Sklad
  Route::get('/dalks',    'SkladController@outTask');
  Route::get('/dalks/q',  'SkladController@inTask');
}

{//crone
  //Logistic
  Route::get('/logistic/daily', function(){echo App\Logistic::daily();});  
  //bonus
  Route::get('/bonus/die/sms', function(){
    echo App\Sms::membershipNotification();
    echo App\Sms::bonusNotification();
  });
}

{//Mail
  Route::get('/mail/preview/{id}', function($id){

    $user = App\User::find(751);
    $email = App\Email::jugeGet(['id'=>$id]);
    $html = App\Email::customTags($email->html,$user);
    
    return view('mail.customEmail', ['user' => $user->toarray(),'html' => $html]);
  });
}

//HTTPS
Route::group(['middleware' => [
  'HttpsRR'
  // ,'under-construction'
  ]],function () {
      
    Route::get('/home', function(){return redirect('/');});

    //All
    Route::group(['middleware' => []], function (){

      // Balance      
      Route::get('/balance/current/user', 'BalanceController@currentUserBalance');
      
      //Polygons
      Route::get('/polygons', 'PolygonController@get');

      //Logs
      Route::put('/juge/log', 'JugeLogsController@add');

      {//Shared Order
        Route::post('/shared/order/test/time', 'SharedOrderController@testTime');
        Route::put('/shared/order/open', 'SharedOrderController@open');
        Route::post('/shared/order', 'SharedOrderController@post');
        Route::delete('/shared/order', 'SharedOrderController@delete');
        Route::post('/shared/order/join', 'SharedOrderController@join');
        Route::get('/shared/order/weights', 'SharedOrderController@getWeights');
        Route::get('/shared/order/auth', 'SharedOrderController@byAuth');
        Route::delete('/shared/order/kick', 'SharedOrderController@kick');
        Route::any('/shared/order/handle', 'SharedOrderController@handle');
        Route::any('/shared/order/update', 'SharedOrderController@update');
        Route::any('/shared/order/order', 'SharedOrderController@getOrder');
        Route::post('/shared/order/confirm', 'SharedOrderController@confirm');
        
        {//Shared Order Pay
          // Route::get('/shared/order/pays', 'SharedOrderPayController@get');
          Route::put('/shared/order/pay', 'SharedOrderPayController@pay');
        }
      }
      
      {//Order
        Route::put('/order/log', 'JugeLogsController@orderButton');
        Route::put('/order/log/success', 'JugeLogsController@orderSuccess');
        Route::put('/order/put', 'OrderController@put');
        Route::post('/order/customer', 'OrderController@customerPost');
        Route::any('/order/update/available', 'OrderController@updateAvailable');
      }
          
      {//Anounces
        Route::get('/announce/auth', 'AnnounceController@byAuth');
        Route::delete('/announce', 'AnnounceController@delete');
      }
      
      {//Cart
        Route::get('/json/cart', 'CartController@get');
        Route::post('/cart/edit/item', 'CartController@editItem');
        Route::post('/cart/session', 'CartController@changeSession');
        Route::delete('/cart/remove/item', 'CartController@removeItem'); 
        Route::delete('/cart/reset', 'CartController@resetItems');
        Route::post('/cart/container', 'CartController@editContainer');
        Route::delete('/cart/container', 'CartController@removeContainer');
        Route::put('/cart/from/local', 'CartController@cartFromLocal');
      }

      //Coupon
      Route::any('/coupon/cart', 'CouponController@cartAttach');

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
      Route::put('/sms/add/send', 'SmsController@sendAdd');
      Route::any('/sms/add/input', 'SmsController@smsAddInput');

      //Errors
      Route::put('/error', 'ErrorController@put');

      
      {//Auth
        Auth::routes();
        Route::put('/fast/register', 'FastRegisterController@fastRegister');
        Route::put('/fast/register/user', 'FastRegisterController@fastRegisterUser');
      }
      
      //User
      Route::get('/auth/user', 'UserController@getAuthUser');
      Route::post('/user', 'UserController@post');
      Route::post('/user/main/photo', 'UserController@editMainPhoto');
      //User Addresses    
      Route::post('/user/address', 'UserController@postAddress');
      Route::put('/user/address', 'UserController@addAddress');
      Route::delete('/user/address', 'UserController@deleteAddress');
      Route::post('/user/address/default', 'UserController@setDefaultAddress');
      //Session Addresses      
      Route::get('/session/addresses', 'UserController@getAddresses');
      

      //Product
      Route::get('/product/last/update', 'ProductController@lastUpdate'); 

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

    });
    
    //Admin
    Route::group(['middleware' => ['auth', 'can:admin_panel']], function (){

      //Debug
      Route::get('/admin/test', function(){
        echo 'Здесь происходит, что-то очень важное 🎩🎩';
      });

      //Logs
      Route::get('/admin/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

      {//Sklad
        Route::get('/sklad/get', 'SkladController@get');
        Route::put('/sklad', 'SkladController@put');
        Route::get('/sklad/get/logs', 'SkladController@getLogs');
      }
      
      {//Polygons
        Route::put('/admin/polygons', 'PolygonController@put');
        Route::get('/admin/polygons', 'PolygonController@get');
        //Polygons price
        Route::put('/admin/polygons/price', 'PolygonController@putPrice');
        Route::delete('/admin/polygons/price', 'PolygonController@deletePrice');
      }
      
      {//Libaras
        Route::put('/admin/libra', 'LibraController@put');
        Route::post('/admin/libra/sort', 'LibraController@sortByName');
        Route::post('/admin/libra/update', 'LibraController@update');
        Route::get('/admin/libra/logs', 'LibraController@getLogs');
        Route::get('/admin/libra/last/product/update', 'LibraController@lastProductUpdate');
        Route::get('/admin/libra/last/update', 'LibraController@lastLibraUpdate');
        Route::get('/admin/libra/vesi/odin', function(){return Storage::download('/vesi/odin.txt');});
      }     
      
      {//Email
        Route::put('/admin/email', 'EmailController@put');
        Route::post('/admin/email', 'EmailController@post');
        Route::put('/admin/test/mail', 'EmailController@testMail');
      }

      //Confirm
      Route::get('/to/confirm/orders', 'OrderController@getToConfirmOrders');

      //Logistic
      Route::post('/logistic/change/driver', 'LogisticController@changeDriver');
      
      //Bonus      
      Route::put('/bonus/add', 'BonusController@add');     
      
      //Balance
      Route::put('/balance', 'BalanceController@edit');
            
      {//User
        Route::get('/login/as/user', 'UserController@loginAsUser');  
        Route::post('/user/to/driver', 'UserController@toDriver');  
        Route::post('/user/to/collector', 'UserController@toСollector');  
        Route::get('/json/drivers', 'UserController@getDrivers'); 
      }
      
      {//Items
        Route::get('/json/items', 'ItemController@jsonGet');    //  
        Route::get('/json/item/statuses', 'ItemStatusController@jsonGetStatuses');
        Route::delete('/item', 'ItemController@delete');
        Route::post('/item', 'ItemController@post');
      }      
      
      {//Menus\Pages
        Route::put('/page', 'PageController@put');
        Route::post('/page', 'PageController@post');
        Route::post('/page/menu/attach', 'PageController@attach');
        Route::post('/page/menu/detach', 'PageController@detach');
        Route::post('/page/site/attach', 'PageController@attachSite');
        Route::post('/page/site/detach', 'PageController@detachSite');
        Route::put('/menu', 'MenuController@put');
      }
      
      {//Referrals
        Route::get('/referral/user/balance', 'ReferralController@getUserBalance');
      }
      
      {//Coupons
        Route::post('/coupon', 'CouponController@post');
        Route::put('/coupon', 'CouponController@put');
        // Route::get('/order/limit/settings', 'OrderController@getLimitSettings');
      };

      {//Coupons referral
        Route::post('/coupon/referral', 'CouponController@attachReferral');        
        Route::get('/coupon/referral', 'CouponController@getReferralCoupon');        
      }
      
      {//Order Limits
        Route::get('/orders/calendar', 'OrderController@getCalendarOrders');
        Route::get('/order/limit/settings', 'OrderController@getLimitSettings');
      }
      
      {//Category
        Route::put('/category', 'CategoryController@put');
        Route::post('/category', 'CategoryController@post');
        Route::post('/categoty/main/photo', 'CategoryController@editMainPhoto');
        Route::post('/category/product/detach', 'CategoryController@detachProduct');
        Route::post('/category/product/attach', 'CategoryController@attachProduct');
        Route::post('/category/category/detach', 'CategoryController@detachCategory');
        Route::post('/category/category/attach', 'CategoryController@attachCategory');
      }
            
      {//Settings
        Route::post('/settings', 'SettingController@post');  
        Route::delete('/settings', 'SettingController@delete');  
      }
      
      {//Present
        Route::put('/admin/product/present', 'PresentController@putProduct'); 
        Route::delete('/admin/product/present', 'PresentController@deleteProduct'); 
      }
      
      {//File upload
        Route::post('/file/upload', 'FileUploadController@fileUpload');
        Route::delete('/file/delete', 'FileUploadController@fileDelete');
      }
      
      {//Order
        Route::post('/order', 'OrderController@post');
        Route::put('/order/item', 'OrderController@addItem');

        {//Order Extra Cherges
          Route::put('/order/extra/charge', 'OrderController@addExtraCharge');
          Route::delete('/order/extra/charge', 'OrderController@removeExtraCharge');
        }
      }
            
      {//Product
        Route::put('/product', 'ProductController@put');
        Route::post('/product', 'ProductController@post');
        Route::get('/json/products', 'ProductController@get');
        Route::get('/base64/preloaded/images', 'ProductController@getBase64PreloadedImages');

        //Product Published
        Route::post('/product/publish', 'ProductController@publish');

        //Delivery days
        Route::post('/product/delivery/limits', 'ProductController@editDeliveryLimits');

        //Main photo
        Route::post('/product/main/photo', 'ProductController@editMainPhoto');
        
        //Config List
        Route::get('/config', 'ListConfigController@get');
        Route::post('/config/post', 'ListConfigController@post');

        //Product discount
        Route::post('/product/discount/set', 'ProductController@postPrice');
        // Route::post('/product/discount/set', 'ProductController@setDiscount');
        Route::delete('/product/discount/remove', 'ProductController@removeDiscount');

        //Discount
        Route::delete('/discount/remove', 'DiscountController@remove');
        Route::put('/discount/add', 'DiscountController@add');
      }
      
      {//Report

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

      }
      
      {//Supplier
        Route::get('/json/suppliers', 'SupplierController@jsonGet');
        Route::get('/json/suppliers/distinct', 'SupplierController@jsonDistinct');
        Route::put('/put/supplier', 'SupplierController@put');
        Route::post('/post/supplier', 'SupplierController@post');
        Route::delete('/delete/supplier', 'SupplierController@delete');
        Route::put('/attach/supplier/product', 'SupplierController@addProduct');
        Route::delete('/remove/supplier/product', 'SupplierController@removeProduct');
        Route::post('/edit/supplier/product/id', 'SupplierController@editId');
      }
      
      {//Juge CRUD
        Route::get('/juge', 'JugeCRUDController@get');
        Route::get('/juge/keys', 'JugeCRUDController@getKeys');
        Route::get('/juge/inputs', 'JugeCRUDController@getInputs');    
        Route::get('/juge/post/inputs', 'JugeCRUDController@getPostInputs');    
        Route::post('/juge', 'JugeCRUDController@post');    
        Route::delete('/juge', 'JugeCRUDController@delete');    
      }

      //Admin panel
      Route::prefix('admin')->group(function (){
        //Vue
        Route::get('/{vue_capture?}', function () {
            return view('admin');
        })->where('vue_capture', '[\/\w\.-]*');    
      });
    });

    //Gruzka
    Route::group(['middleware' => ['auth', 'can:gruzka_panel']], function (){

      //Gruzka
      Route::middleware([])->group(function (){
        Route::put('/gruzka/confirm', 'GruzkaController@confirm');
        Route::put('/gruzka/noitem', 'GruzkaController@noItem');
        Route::put('/gruzka/done', 'GruzkaController@done');
      });

      //Gruzka
      Route::middleware([])->group(function (){  
        Route::get('/json/orders', 'OrderController@jsonGet');
        //Order Status
        Route::get('/json/order/statuses', 'OrderStatusController@jsonGetStatuses');
        Route::put('/order/status', 'OrderStatusController@putStatus');  
      });

      Route::prefix('gruzka')->group(function (){

        //Vue
        Route::get('/{vue_capture?}', function () {
            return view('admin');
        })->where('vue_capture', '[\/\w\.-]*');    
      });

    });

    //Driver
    Route::group(['middleware' => ['auth', 'can:driver_panel']], function (){

      //User
      Route::get('/user/comments', 'UserController@comments');
      Route::put('/add/comment', 'UserController@addComment');
      Route::delete('/delete/comment', 'UserController@deleteComment');

      //Delivery    
      Route::get('/json/deliveries', 'DeliveryController@jsonGet');  
      Route::put('/put/delivery', 'DeliveryController@put');      
      Route::delete('/delivery', 'DeliveryController@delete');
      Route::delete('/delivery/return', 'DeliveryController@deleteReturn');


      //Pay
      Route::get('/json/pay/methods', 'PayController@getMethods');
      Route::get('/pays', 'PayController@get');


      //Return Item
      Route::put('/return/item', 'ReturnItemController@put');      
      Route::delete('/return/item', 'ReturnItemController@delete');        

      //Driver
      Route::prefix('driver')->group(function (){

        //Logistic    
        Route::get('/logistic/keys', 'LogisticController@getDriverLogisticKeys');

        //Vue
        Route::get('/{vue_capture?}', function () {
            return view('admin');
        })->where('vue_capture', '[\/\w\.-]*');    
      });
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

    Auth::routes();    
    
    Route::get('/404', function(){abort(404);});
  }
);
