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

Route::get('/test', function(){
  echo 'Здесь происходит, что-то очень важное 🎩';

    

  // foreach ($smss as $key => $sms) {
  //   App\Sms::putSmsToSend([
  //     'to' => $sms['to'],
  //     'body' =>  "{$sms['name']}, здравствуйте! У Бананыча новая акция недели! 7 самых ходовых сезонных фруктов и овощей по себестоимости и отменного качества! Успейте заказать! https://bananich.ru/discounts"
  //   ]);
    // die;
  // }

  // App\Logistic::getFromRaw();
});

Route::get('/mail', function(){


  // $order = App\Order::getWithOptions(['id'=>14408]);

  // dump(  $order->toarray());

  // $user = App\User::find(751);

  // dd($user);


  // Mail::send('mail.rasilka', ['user' => $user->toarray()], function($m){
  //   // $m->to('aslanovadaria@yandex.ru','to');
  //   // $m->to('mapss@inbox.lv','to');
  //   // $m->to('jurijsgergelaba@yandex.ru','to');
  //   $m->from('no-reply@bananich.ru');
  //   $m->subject('Ваш Бананыч заказ получен!');
  // });

  // Mail::send('mail.open', ['user' => $user->toarray()], function($m){
  //   $m->to('aslanovadaria@yandex.ru','to');
  //   // $m->to('mapss@inbox.lv','to');
  //   // $m->to('jurijsgergelaba@yandex.ru','to');
  //   $m->from('no-reply@bananich.ru');
  //   $m->subject('Бананыч вернулся! И у нас много новостей)');
  // });


  // return view('mail.rasilka', ['user' => $user->toarray()]);
});


// Route::group(['middleware' => ['under-construction','HttpsRR']], function () {
Route::group(['middleware' => ['HttpsRR']], function () {

    
  Route::get('/home', function(){
    return redirect('/');
  });

  Route::get('/test/test', function(){
      //
  });

  //Order
  Route::put('/order/put', 'OrderController@put');
  Route::any('/order/update/available', 'OrderController@updateAvailable');

  //Cart
  Route::get('/json/cart', 'CartController@get');
  Route::post('/cart/edit/item', 'CartController@editItem');
  Route::post('/cart/session', 'CartController@changeSession');
  Route::delete('/cart/remove/item', 'CartController@removeItem'); 
  Route::delete('/cart/reset', 'CartController@resetItems');
  Route::post('/cart/container', 'CartController@editContainer');
  Route::delete('/cart/container', 'CartController@removeContainer');

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

  //Auth
  Auth::routes();

  //User
  Route::get('/auth/user', 'UserController@getAuthUser');
  Route::post('/user', 'UserController@post');
  Route::post('/user/address', 'UserController@postAddress');
  Route::post('/user/main/photo', 'UserController@editMainPhoto');

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


  //Driver
  Route::group(['middleware' => ['auth', 'can:driver']], function (){

    //Admin panel
    Route::prefix('driver')->group(function (){

      Route::get('/logistic/keys', 'LogisticController@getDriverLogisticKeys');

      //Vue
      Route::get('/{vue_capture?}', function () {
          return view('admin');
      })->where('vue_capture', '[\/\w\.-]*');    
    });


  });



  //Admin
  Route::group(['middleware' => ['auth', 'can:admin panel']], function (){

    Route::get('/admin/test', function(){
      echo 'Здесь происходит, что-то очень важное 🎩🎩';
    
      // $bonuses = App\Bonus::where('created_at', '<', '2020-09-27 13:02:20')->pluck('user_id');

      // $users = [];
      // foreach ($bonuses as $key => $user) {
        
      //   $gg = App\Bonus::where('user_id', $user)->get();
    
      //   if($gg->count() == 1) array_push($users, $user);
       
      // }
    
      // $bonuses = App\Bonus::whereIn('user_id', $users)->with('user')->with('addBonus')->get();
    
      // foreach ($bonuses as $key => $bonus) {
      //   // dump($bonus->toArray());
    
      //   // dump('user ' . $bonus->user->name . "({$bonus->user->phone})" . '  -  '. 'bonus ' .$bonus->left);
    
      //   $body = "{$bonus->user->name}. Здравствуйте! Бананыч вернулся! У нас много новостей и крутой сайт, а у вас- {$bonus->left} бонусов, которые вы можете потратить на bananich.ru до 10.18! Ждем вас!";
        
      //   dump($body);
    
      //   App\Sms::putSmsToSend(['to' => $bonus->user->phone,  'body' => $body, 'priority' => 5]);
    
      // } 
      
    
      // App\Logistic::getFromRaw();
    });

    //VEsi
    Route::get('make/vesi', function(){


      $data = json_decode('
      {
        "type": "FeatureCollection",
        "name": "финал",
        "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:EPSG::3857" } },
        "features": [
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Vegan superfood", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 351, "Белки(Click to sort Ascending)": 19, "Жиры(Click to sort Ascending)": 7, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "какао-порошок, мака перуанская, зерна канихуа, мука из семян люпина, мука из киноа, амарантовая мука, порошок из мескита, стевия, панела,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 220, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Амарант, премиум мука жмыховая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 344, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 4, "Углеводы(Click to sort Ascending)": 68, "Состав(Click to sort Ascending)": "мука амарантовая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 95, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ананас кольцами, цукат", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 91, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 18, "Состав(Click to sort Ascending)": "кольца ананаса, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 145, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 580, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 42, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "арахис жареный, шоколадная глазурь белая,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в кокосовом сиропе", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 636, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 30, "Углеводы(Click to sort Ascending)": 50, "Состав(Click to sort Ascending)": "арахис, пшеничная мука, крахмал, сахар, растительное масло, кокосовый сок, соль,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 95, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в кунжуте", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 528, "Белки(Click to sort Ascending)": 19, "Жиры(Click to sort Ascending)": 36, "Углеводы(Click to sort Ascending)": 33, "Состав(Click to sort Ascending)": "ядра арахиса, кунжут, сахарная пудра, сахар, патока.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 540, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 38, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "арахис жареный, шоколадная глазурь темная,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис неочищенный", "Страна(Click to sort Ascending)": "Аргентина", "Калории(Click to sort Ascending)": 587, "Белки(Click to sort Ascending)": 27, "Жиры(Click to sort Ascending)": 48, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "арахис в скорлупе.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 27, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис очищенный", "Страна(Click to sort Ascending)": "Аргентина", "Калории(Click to sort Ascending)": 552, "Белки(Click to sort Ascending)": 26, "Жиры(Click to sort Ascending)": 45, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "арахис очищенный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 25, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Банановые чипсы", "Страна(Click to sort Ascending)": "Филиппины", "Калории(Click to sort Ascending)": 487, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 30, "Углеводы(Click to sort Ascending)": 51, "Состав(Click to sort Ascending)": "банан, кокосовое масло, сахар, мед", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 50, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Бананы сушеные Вьетконг", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 339, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 54, "Состав(Click to sort Ascending)": "бананы сушеные,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Белая фасоль", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 237, "Белки(Click to sort Ascending)": 17, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 41, "Состав(Click to sort Ascending)": "белая фасоль", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 105, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Бразильский орех", "Страна(Click to sort Ascending)": "Бразилия", "Калории(Click to sort Ascending)": 656, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 66, "Углеводы(Click to sort Ascending)": 12, "Состав(Click to sort Ascending)": "бразильский орех", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Вечерний чай", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: цейлонский черный чай, ягоды брусники, кусочки яблока, цедра лимона и листья мяты.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Витграсс премиум, молотые ростки", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 195, "Белки(Click to sort Ascending)": 22, "Жиры(Click to sort Ascending)": 3, "Углеводы(Click to sort Ascending)": 22, "Состав(Click to sort Ascending)": "молодые зеленые побеги пшеницы,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 140, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Вишня вяленая", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 73, "Состав(Click to sort Ascending)": "вишня, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 81, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех бабочка", "Страна(Click to sort Ascending)": "Украина", "Калории(Click to sort Ascending)": 654, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 65, "Углеводы(Click to sort Ascending)": 7, "Состав(Click to sort Ascending)": "грецкий орех.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех в шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 577, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 43, "Углеводы(Click to sort Ascending)": 38, "Состав(Click to sort Ascending)": "бланшированный грецкий орех, шоколадная глазурь темная,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех целый Чили", "Страна(Click to sort Ascending)": "Чили", "Калории(Click to sort Ascending)": 656, "Белки(Click to sort Ascending)": 16, "Жиры(Click to sort Ascending)": 61, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "грецкий орех целый", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 81, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех четвертинки", "Страна(Click to sort Ascending)": "Украина", "Калории(Click to sort Ascending)": 648, "Белки(Click to sort Ascending)": 16, "Жиры(Click to sort Ascending)": 65, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "грецкий орех четвертинки", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Гречка зеленая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 296, "Белки(Click to sort Ascending)": 11, "Жиры(Click to sort Ascending)": 3, "Углеводы(Click to sort Ascending)": 56, "Состав(Click to sort Ascending)": "гречка зеленая", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Груша вяленая", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 270, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 63, "Состав(Click to sort Ascending)": "груша, сахар.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 174, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Женьшень Улун (оолонг)", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: чайный лист, корень женьшеня, падуб широколистный, солодка", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Здоровое пищеварение", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный китайский чай, оолонг, душица, мята, имбирь, ромашка, плоды можжевельника, тысячелистник, ягоды малины, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Иван-чай Вологодский с вишней", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "кипрей узколистный ферментированный, листья вишни,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 459, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 22, "Углеводы(Click to sort Ascending)": 67, "Состав(Click to sort Ascending)": "сушеный виноград без косточки, белая шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 455, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 21, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "сушеный виноград без косточки, темная шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм светлый", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 232, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 51, "Состав(Click to sort Ascending)": "изюм светлый", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм черный", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 283, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "изюм черный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Инжир горный натуральный", "Страна(Click to sort Ascending)": "Турция", "Калории(Click to sort Ascending)": 213, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 52, "Состав(Click to sort Ascending)": "инжир горный натуральный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 180, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Инжир", "Страна(Click to sort Ascending)": "Турция", "Калории(Click to sort Ascending)": 257, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "инжир", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Какао Премиум, порошок натуральный", "Страна(Click to sort Ascending)": "Бразилия", "Калории(Click to sort Ascending)": 417, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 11, "Углеводы(Click to sort Ascending)": 53, "Состав(Click to sort Ascending)": "какао-порошок,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Какао-масло натуральное Belcolade", "Страна(Click to sort Ascending)": "Бельгия", "Калории(Click to sort Ascending)": 899, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 100, "Состав(Click to sort Ascending)": "100% натуральное какао-масло,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 18000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Каркаде", "Страна(Click to sort Ascending)": "Россия", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 50, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кедровый орех", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 674, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "кедровый орех", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 230, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 43, "Углеводы(Click to sort Ascending)": 42, "Состав(Click to sort Ascending)": "кешью, белая шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 568, "Белки(Click to sort Ascending)": 11, "Жиры(Click to sort Ascending)": 42, "Углеводы(Click to sort Ascending)": 39, "Состав(Click to sort Ascending)": "кешью, темная шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью нежареный", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 554, "Белки(Click to sort Ascending)": 18, "Жиры(Click to sort Ascending)": 43, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "кешью.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью обжаренный", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 46, "Углеводы(Click to sort Ascending)": 32, "Состав(Click to sort Ascending)": "кешью обжаренный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 140, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киви вяленый", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 285, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 85, "Состав(Click to sort Ascending)": "киви, сахар", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киноа белая Премиум, зерно", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 345, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 69, "Состав(Click to sort Ascending)": "белое киноа, соль, сушёный томат молотый, лук молотый, чёрный перец молотый, панела молотая, кумин, орегано, чеснок молотый, базилик,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киноа белая Премиум, мука цельнозерновая", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 380, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 5, "Углеводы(Click to sort Ascending)": 71, "Состав(Click to sort Ascending)": "мука из киноа белого,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 260, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киноа белая Премиум, хлопья с Макой перуанской", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 385, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 4, "Углеводы(Click to sort Ascending)": 78, "Состав(Click to sort Ascending)": "хлопья из бланшированного киноа с сушёной Макой,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 134, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Клубника вяленая", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 84, "Состав(Click to sort Ascending)": "клубника, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос натуральный сушеный БЕЗ сахара", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 700, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "высушенные кусочки натурального кокоса,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, молоко сухое", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 720, "Белки(Click to sort Ascending)": 12, "Жиры(Click to sort Ascending)": 64, "Углеводы(Click to sort Ascending)": 24, "Состав(Click to sort Ascending)": "сухое кокосовое молоко, мальтодекстрин,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, мука", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 466, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 16, "Углеводы(Click to sort Ascending)": 60, "Состав(Click to sort Ascending)": "мука кокосовая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 145, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, сахар", "Страна(Click to sort Ascending)": "Индонезия", "Калории(Click to sort Ascending)": 380, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 95, "Состав(Click to sort Ascending)": "кокосовый сахар,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, стружка 65%", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 713, "Белки(Click to sort Ascending)": 7, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "стружка кокосовая,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 33, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, стружка низкой жирности", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 709, "Белки(Click to sort Ascending)": 7, "Жиры(Click to sort Ascending)": 45, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "стружка кокосовая", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, чипсы натуральные", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 700, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "кокосовая стружка,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокосовая стружка medium", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 693, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 65, "Углеводы(Click to sort Ascending)": 14, "Состав(Click to sort Ascending)": "стружка кокосовая,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 25, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокосовые кубики натуральные", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 470, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 23, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "кокос натуральный сушеный,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Компот из сухофруктов", "Страна(Click to sort Ascending)": "Таджикистан", "Калории(Click to sort Ascending)": 205, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 33, "Состав(Click to sort Ascending)": "абрикос сушеный, яблоко сушеное, чернослив с косточкой, груша сушеная, вишня сушеная.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 50, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Амаретто", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Бейлиз", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Бейлиз", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе в зернах Бразилия Сантос Моджиана", "Страна(Click to sort Ascending)": "Бразилия", "Состав(Click to sort Ascending)": "Состав: 100% арабика", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 119, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе в зернах Колумбия Супремо", "Страна(Click to sort Ascending)": "Колумбия", "Состав(Click to sort Ascending)": "Состав: 100% арабика", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 137, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ваниль", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ванильно-сливочный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Имбирный лимон", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ириска", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ирландский крем", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Мокко-кокос", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе с мятой", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Тирамису", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кунжут черный", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 565, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 12, "Состав(Click to sort Ascending)": "семена кунжута неочищенные", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кунжут", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 565, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 12, "Состав(Click to sort Ascending)": "кунжут", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Курага", "Страна(Click to sort Ascending)": "Таджикистан", "Калории(Click to sort Ascending)": 232, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 51, "Состав(Click to sort Ascending)": "курага", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 114, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кэроб молотый без обжарки", "Страна(Click to sort Ascending)": "Алжир", "Калории(Click to sort Ascending)": 230, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 89, "Состав(Click to sort Ascending)": "молотый кэроб,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Леди Совершенство", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: мате, мелисса, оолонг, лимонграсс, гибискус, имбирь, ягоды клюквы, облепихи, яблоко, лепестки роз, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Лен", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 534, "Белки(Click to sort Ascending)": 18, "Жиры(Click to sort Ascending)": 42, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "лен", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Лукума Суперфуд, напиток", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 337, "Белки(Click to sort Ascending)": 7, "Жиры(Click to sort Ascending)": 3, "Углеводы(Click to sort Ascending)": 78, "Состав(Click to sort Ascending)": "порошок из плодов лукумы, мука киноа клейстеризованная, порошок из мексита, молотая корица,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 190, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мака перуанская Суперфуд, молотый", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 325, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 4, "Углеводы(Click to sort Ascending)": 71, "Состав(Click to sort Ascending)": "мука из молотой маки.", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Макадамия", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 718, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 76, "Углеводы(Click to sort Ascending)": 14, "Состав(Click to sort Ascending)": "макадамия", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Манго вяленое, цукаты", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 314, "Белки(Click to sort Ascending)": 22, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 82, "Состав(Click to sort Ascending)": "сушеное манго, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мате земляничный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: мате, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мате классический", "Страна(Click to sort Ascending)": "Аргентина", "Состав(Click to sort Ascending)": "Соста: высушенные и измельчённые листья падуба парагвайского", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 105, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Матча чай Премиум, мелкого помола", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 60, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "чай молотый матча,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 305, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Маш", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 300, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 46, "Состав(Click to sort Ascending)": "маш", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 564, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 39, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "обжаренный миндаль, шоколадная глазурь белая,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 564, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 39, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "обжаренный миндаль, шоколадная глазурь темная,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль обжаренный", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 609, "Белки(Click to sort Ascending)": 19, "Жиры(Click to sort Ascending)": 54, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "миндаль обжаренный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль сырой", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 575, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "миндаль сырой", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука миндальная", "Страна(Click to sort Ascending)": "Испания", "Калории(Click to sort Ascending)": 602, "Белки(Click to sort Ascending)": 26, "Жиры(Click to sort Ascending)": 55, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "Мука миндальная", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 510, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука нутовая", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 387, "Белки(Click to sort Ascending)": 22, "Жиры(Click to sort Ascending)": 7, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "Мука нутовая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 170, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 23000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука фисташковая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 557, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 50, "Углеводы(Click to sort Ascending)": 7, "Состав(Click to sort Ascending)": "Мука фисташковая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 350, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука черемуховая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 101, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "Мука черемуховая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 320, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мята Kejo", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 285, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 22, "Состав(Click to sort Ascending)": "листья мяты сушеные,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мята Памирская", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 285, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 22, "Состав(Click to sort Ascending)": "листья мяты сушеные,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мята сушеная армянская", "Страна(Click to sort Ascending)": "Армения", "Состав(Click to sort Ascending)": "листья и мяты чабреца сушеные", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.03, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральное сушеное манго БЕЗ сахара", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 261, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "высушенное манго без сахара,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральное сушеное помело БЕЗ сахара", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 90, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 67, "Состав(Click to sort Ascending)": "натуральное сушеное помело", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 170, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральный банан вяленый БЕЗ сахара", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 346, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 88, "Состав(Click to sort Ascending)": "натуральный банан вяленый.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 155, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральный сушеный ананас БЕЗ сахара", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 275, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 65, "Состав(Click to sort Ascending)": "натуральный сушеный ананас.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 180, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Нут крупный", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 390, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 5, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "нут крупный", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Нут стандарт", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 390, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 5, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "нут стандарт", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Озорной фрукт", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: гибискус, яблоко, шиповник, изюм, абрикос, персик, ананас, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Пекан очищенный", "Страна(Click to sort Ascending)": "Чили", "Калории(Click to sort Ascending)": 691, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 72, "Углеводы(Click to sort Ascending)": 14, "Состав(Click to sort Ascending)": "пекан очищенный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 205, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Премиум смесь женская antiage", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 303, "Белки(Click to sort Ascending)": 11, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 75, "Состав(Click to sort Ascending)": "порошок из корня маки, порошок из банана, порошок мескита, порошок хуанарпо мачо, какао-порошок, молотый имбирь,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 175, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Премиум смесь\"Иммунитет 7 суперфудов\"", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 317, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 73, "Состав(Click to sort Ascending)": "порошок мескита (перуанский кэроб), порошок из бразильского ореха, молотая фиолетовая кукуруза, молотый имбирь, порошок из лукумы, порошок из фрукта нони, порошок Камю Камю,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 175, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Рецепт долголетия", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, кусочки ананаса, лепестки сафлора, цедра лимона, ароматизаторы.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Рис Басмати", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 331, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 74, "Состав(Click to sort Ascending)": "рис басмати", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 105, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ройбуш классический", "Страна(Click to sort Ascending)": "ЮАР", "Состав(Click to sort Ascending)": "Состав: высушенные и измельчённые листья и побеги аспалатуса линейного", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ройбуш черничный", "Страна(Click to sort Ascending)": "ЮАР", "Состав(Click to sort Ascending)": "Состав: высушенные и измельчённые листья и побеги аспалатуса линейного, ароматизатор", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена подсолнуха н\/о жареные", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 601, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 52, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена подсолнуха н\/о жареные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена подсолнуха н\/о сырые", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 601, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена подсолнуха н\/о сырые", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 35, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена подсолнуха очищенные", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 8, "Состав(Click to sort Ascending)": "семена подсолнуха очищенные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена тыквы н\/о жареные", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 8, "Состав(Click to sort Ascending)": "семена тыквы н\/о жареные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена тыквы н\/о", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 559, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена тыквы н\/о", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена тыквы очищенные", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 559, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена тыквы очищенные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена чиа", "Страна(Click to sort Ascending)": "Парагвай", "Калории(Click to sort Ascending)": 486, "Белки(Click to sort Ascending)": 17, "Жиры(Click to sort Ascending)": 31, "Углеводы(Click to sort Ascending)": 8, "Состав(Click to sort Ascending)": "семена чиа", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Соль розовая гималайская, мелкий помол", "Страна(Click to sort Ascending)": "Пакистан", "Калории(Click to sort Ascending)": 5, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 1, "Состав(Click to sort Ascending)": "розовая гималайская соль,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Соль черная гималайская, мелкий помол", "Страна(Click to sort Ascending)": "Пакистан", "Калории(Click to sort Ascending)": 1, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 0, "Состав(Click to sort Ascending)": "черная гималайская соль,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Спирулина, порошок", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 350, "Белки(Click to sort Ascending)": 60, "Жиры(Click to sort Ascending)": 8, "Углеводы(Click to sort Ascending)": 15, "Состав(Click to sort Ascending)": "молотые одноклеточные водоросли спирулина,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 140, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Сушеный ананас кубиками микс цукат", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 91, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 18, "Состав(Click to sort Ascending)": "ананас, сахар, пищевой краситель,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Топинамбур Премиум, сушеный молотый", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 346, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 73, "Состав(Click to sort Ascending)": "сушеный молотый топинамбур,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Тыква Премиум, порошок", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 40, "Жиры(Click to sort Ascending)": 10, "Углеводы(Click to sort Ascending)": 23, "Состав(Click to sort Ascending)": "порошок из семян тыквы,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 215, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Тыква Премиум, с высоким содержанием белка", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 40, "Жиры(Click to sort Ascending)": 10, "Углеводы(Click to sort Ascending)": 23, "Состав(Click to sort Ascending)": "порошок из семян тыквы,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 215, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Улун банановый", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: улун, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Улун Шоколадный", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: улун, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фасоль белая с черными точками", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 340, "Белки(Click to sort Ascending)": 23, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 60, "Состав(Click to sort Ascending)": "фасоль белая с черными точками", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики иранские в коробке", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 292, "Белки(Click to sort Ascending)": 25, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 69, "Состав(Click to sort Ascending)": "финики иранские", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 220, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики королевские Экстра", "Страна(Click to sort Ascending)": "Израиль", "Калории(Click to sort Ascending)": 277, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 75, "Состав(Click to sort Ascending)": "финики королевские экстра", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики королевские", "Страна(Click to sort Ascending)": "Израиль", "Калории(Click to sort Ascending)": 294, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 69, "Состав(Click to sort Ascending)": "плоды финиковой пальмы,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики Шоколад", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 282, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 75, "Состав(Click to sort Ascending)": "финики шоколад", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фисташки жареные соленые", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 610, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 50, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "обжаренные в скорлупе фисташки, соль,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фисташки сырые", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 562, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 45, "Углеводы(Click to sort Ascending)": 28, "Состав(Click to sort Ascending)": "фисташки сырые", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фруктовая смесь Клубничный зефир", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: гибискус, кусочки яблока, клубники, шиповник, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 77, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 591, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 59, "Углеводы(Click to sort Ascending)": 36, "Состав(Click to sort Ascending)": "обжаренный фундук, белая шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук в скорлупе", "Страна(Click to sort Ascending)": "Дагестан", "Калории(Click to sort Ascending)": 650, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 61, "Углеводы(Click to sort Ascending)": 9, "Состав(Click to sort Ascending)": "фундук в скорлупе", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 577, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 41, "Углеводы(Click to sort Ascending)": 39, "Состав(Click to sort Ascending)": "обжаренный фундук, темная шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук обжаренный", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 629, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 61, "Углеводы(Click to sort Ascending)": 17, "Состав(Click to sort Ascending)": "очищенные и обжаренные ядра фундука,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук сырой", "Страна(Click to sort Ascending)": "Дагестан", "Калории(Click to sort Ascending)": 651, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 62, "Углеводы(Click to sort Ascending)": 9, "Состав(Click to sort Ascending)": "фундук сырой", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Хурма вяленая", "Страна(Click to sort Ascending)": "Армения", "Калории(Click to sort Ascending)": 241, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "вяленая хурма, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 240, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Цукаты помело", "Страна(Click to sort Ascending)": "Тайланд", "Состав(Click to sort Ascending)": "помело, сахар 60-65%, диоксид серы, лимонная кислота", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чабрец высокогорный Kejo", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "стебель, лист, цветы чабреца,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чабрец Памир", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "стебель, лист, цветы чабреца,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чабрец сушеный армянский", "Страна(Click to sort Ascending)": "Армения", "Состав(Click to sort Ascending)": "листья и стебли чабреца сушеные", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.03, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Азерчай", "Страна(Click to sort Ascending)": "Азербайджан", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 65, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай бронхиальный сбор", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: трава мать-и-мачехи, ежевика, чабрец, подорожник, цветки ромашки, листья подсолнечника, липа, бузина, зверобой", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Годжи-Земляника", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, ягоды Годжи, земляники, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Граф Грей", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный китайский чай, бергамот, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Дяньхун", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый \"Земляника со сливками\"", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай, кусочки земляники, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 67, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый Жасминовый (с бутонами)", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: зеленый листовой чай, цветы жасмина, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый Имбирный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай, имбирь. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 65, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый с мятой", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай ганпаудер, натуральная мята.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый с чабрецом", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай, чабрец. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый Фрукты тропиков", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный индийский чай, сушеное манго, ананас, киви, персик, папайя, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Кокосовый улун (оолонг)", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: улун, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 69, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Король солнце", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: индийский черный чай, корица, имбирь, лепестки календулы, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Лапсанг Сушонг", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Молочный улун (Най Сян Улун)", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 98, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Монастырский", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, мята, душица, липовый цвет, зверобой, корень девясила и шиповник.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Пуэр То ча", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: китайский чёрный чай Пуэр", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 25, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Пуэр Хайвань мини чаши, Класс А", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 35, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай с чабрецом", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, чабрец.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 65, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Сенча", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: Чай сенча", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 47, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Таёжное озеро", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, ягоды клюквы, облепихи, рябины, сосновые почки и плоды можжевельника, листья смородины и крапивы, ароматизаторы.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Те Гуань инь", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Черника в йогурте", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: отборный цейлонский черный чай, ягоды черники, лепестки василька, листья смородины, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Витаминный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: индийский черный чай, цейлонский черный чай, ягоды и листья смородины, плоды боярышника, шиповник, цедра апельсина, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 81, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Земляника со сливками", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, кусочки земляники, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 77, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Имбирный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, имбирь. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 83, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Шоколадный коктейль", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "черный индийский чай, кусочки молочной карамели,какао-бобов, ягод облепихи и брусники, ароматизатор", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чернослив без косточек", "Страна(Click to sort Ascending)": "Чили", "Калории(Click to sort Ascending)": 261, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "чернослив без косточек", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чечевица красная", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 284, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 54, "Состав(Click to sort Ascending)": "чечевица красная", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чечевица", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 319, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 53, "Состав(Click to sort Ascending)": "чечевица", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чиа черная Премиум, мука жмыховая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 890, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 99, "Состав(Click to sort Ascending)": "мука из семян чиа,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 190, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
          { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ягоды Годжи", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 343, "Белки(Click to sort Ascending)": 12, "Жиры(Click to sort Ascending)": 7, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "ягоды годжи", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null }
        ]
      }');

      $content = '';
      $list = '';

      foreach ($data->features as $key => $item) {
        $v = $item->properties;
                
        //Set name
        if('name' == 'name'){
          $name = '(Click to sort Ascending)';
          $len = iconv_strlen($v->$name);
          if($len > 79){
            dump($v->$name);
            continue;
          } 
          for ($i=0; $i < (80 - $len); $i++) { 
            $v->$name .= ' ';
          }
        }

        //Set button
        if('button' == 'button'){
          $button = $key+1;
          $len = iconv_strlen($button);
          $pre_button = '';
          for ($i=0; $i < (15 - $len); $i++) { 
            $pre_button .= '0';
          }
          $button = $pre_button . $button;
        }

        //set price
        if('price' == 'price'){
          $price = 'Цена(Click to sort Ascending)';
          $unit = 'Единица (сис)(Click to sort Ascending)';

          $price_full = number_format((float)((1 / $v->$unit) * $v->$price), 2, '.', '');
          $len = iconv_strlen($price_full);
          $pre = '';
          for ($i=0; $i < (8 - $len); $i++) { 
            $pre .= '0';
          }
          $price_full = $pre . $price_full;
        }

        
        $pa1 = 'A220000100000';
        $pa2_button = $button;
        $pa3 = '0001000100';
        $pa4_price = $price_full;
        $pa5_days = '000';
        $pa6 = '0000';
        $pa7_name = $v->$name;
        $pa8 = "\r\n";

        $string = $pa1.$pa2_button.$pa3.$pa4_price.$pa5_days.$pa6.$pa7_name;
  
        //set country
        if('country' == 'country'){
          $country = 'Страна(Click to sort Ascending)';

          $val = 'Страна: ' . $v->$country;
          $len = iconv_strlen($val);
          if($len > 48){
            dump('bad country', $v);
            continue;
          }

          $len = iconv_strlen($val);
          for ($i=0; $i < (100 - $len); $i++) { 
            $val .= ' ';
          }
          
          $string .= $val;
        }

        //Ccal
        if('ccal' == 'ccal'){
          
          $name = 'Калории(Click to sort Ascending)';
          if(isset($v->$name)){
            $val = 'Калории: ' . $v->$name;
            $len = iconv_strlen($val);
            if($len > 48){
              dump('bad Калории', $val);
              continue;
            }

            $len = iconv_strlen($val);
            for ($i=0; $i < (100 - $len); $i++) { 
              $val .= ' ';
            }
            
            $string .= $val;
          }
        }     

        //Бжу
        if('Бжу' == 'Бжу'){
          $prots = 'Белки(Click to sort Ascending)';
          $fats = 'Жиры(Click to sort Ascending)';
          $carbs = 'Углеводы(Click to sort Ascending)';

          if(isset($v->$prots) && isset($v->$fats) && isset($v->$carbs)){

            $val = "БЖУ: {$v->$prots}/{$v->$fats}/{$v->$carbs}" ;
            $len = iconv_strlen($val);
            if($len > 48){
              dump('bad БЖУ', $v, $val);
              continue;
            }
            
            $len = iconv_strlen($val);
            for ($i=0; $i < (100 - $len); $i++) { 
              $val .= ' ';
            }
            
            $string .= $val;
          }
        }    
        
        //Состав
        if('Состав' == 'Состав'){
          
          $name = 'Состав(Click to sort Ascending)';
          if(isset($v->$name)){
            $val = $v->$name;
            $val = 'Состав: ' . $v->$name;            
            $val = str_replace('Состав: Состав:','Состав:',$val);
            $len = iconv_strlen($val);
            $more_sostav = [];
            if($len > 48){
              $left = $val;
              do{                
                $str = mb_substr  ( $left , 0, 45 );
                $left = mb_substr  ( $left , 45 );                
                array_push($more_sostav,$str);                
                if($left == FALSE ) break;
              }while(1);
              
              if(count($more_sostav) > 5){
                dump('bad Состав', $val);
                continue;
              }
            }

            if(count($more_sostav) == 0){
              $more_sostav[1] = $val;
            }

            foreach ($more_sostav as $key => $val) {
              $len = iconv_strlen($val);
              for ($i=0; $i < (100 - $len); $i++) { 
                $val .= ' ';
              }
              $string .= $val;
            }           
            
          }
        }  

        $string .= "\r\n";

        $content .= $string;

        $list .= $pa2_button . '  ' . $pa7_name . "\r\n";

      }

      $b = "B00010001Товарная группа #1            \r\n";
      $a = "T0001Отдел поставки товаров        \r\n";
      
      $content = $b . $content . $a;

      Storage::disk('local')->put('up95.txt', mb_convert_encoding($content, 'Windows-1251'));

      dump($list);

      dd($content);
      
    });

    Route::get('make/vesi/odin', function(){
      //
      
      $data = json_decode('{
        "type": "FeatureCollection",
        "name": "Sheet1",
        "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:EPSG::3857" } },
        "features": [
        { "type": "Feature", "properties": { "Field1": "(Click to sort Ascending)", "Field2": "Название(Click to sort Ascending)", "Field3": "Страна(Click to sort Ascending)", "Field4": "Калории(Click to sort Ascending)", "Field5": "Белки(Click to sort Ascending)", "Field6": "Жиры(Click to sort Ascending)", "Field7": "Углеводы(Click to sort Ascending)", "Field8": "Условия хранения\/составы", "Field9": "Категории(Click to sort Ascending)", "Field10": "Цена(Click to sort Ascending)", "Field11": "Единица (сис)(Click to sort Ascending)", "Field12": "Сыпучка(Click to sort Ascending)", "Field13": "цена", "Field14": "ОТОБРАЖАТЬ ДАТУ ПЕЧАТИ ЭТИКЕТКИ!!!" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13789", "Field2": "Форель потрошеная холодного копчения", "Field3": "Россия", "Field4": "132", "Field5": "26", "Field6": "3", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "500.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13782", "Field2": "Форель потрошеная с головой в пряном маринаде", "Field3": "Россия", "Field4": "100", "Field5": "19", "Field6": "2", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13787", "Field2": "Форель потрошеная с головой", "Field3": "Россия", "Field4": "97", "Field5": "19", "Field6": "2", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "330.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13788", "Field2": "Форель потрошеная с головой", "Field3": "Россия", "Field4": "97", "Field5": "19", "Field6": "2", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "660.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12881", "Field2": "Окунь горячего копчения", "Field3": "Норвегия", "Field4": "175", "Field5": "23", "Field6": "9", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "480.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12900", "Field2": "Тунец филе свежемороженное", "Field3": "Китай", "Field4": "139", "Field5": "24", "Field6": "4", "Field7": "0", "Field8": "Срок годности: 12 месяцев при t -18С", "Field9": "Рыба и морепродукты", "Field10": "1100.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12869", "Field2": "Форель балык холодного копчения", "Field3": "Норвегия", "Field4": "132", "Field5": "26", "Field6": "3", "Field7": "1", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "650.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12876", "Field2": "Скумбрия горячего копчения", "Field3": "Норвегия", "Field4": "317", "Field5": "22", "Field6": "23", "Field7": "4", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "288.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12867", "Field2": "Горбуша балык холодного копчения", "Field3": "Россия", "Field4": "174", "Field5": "21", "Field6": "10", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12861", "Field2": "Чука свежемороженная", "Field3": "Китай", "Field4": "205", "Field5": "2", "Field6": "5", "Field7": "38", "Field9": "Рыба и морепродукты", "Field10": "425.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12884", "Field2": "Кальмар горячего копчения", "Field4": "128", "Field5": "21", "Field6": "4", "Field7": "2", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "400.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12899", "Field2": "Мидии замороженные", "Field4": "50", "Field5": "9", "Field6": "2", "Field7": "0", "Field9": "Рыба и морепродукты", "Field10": "550.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12862", "Field2": "Филе лосося слабой соли в вакуумной упаковке", "Field3": "Норвегия", "Field4": "233", "Field5": "21", "Field6": "16", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "340.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12879", "Field2": "Салака горячего копчения", "Field3": "Норвегия", "Field4": "152", "Field5": "25", "Field6": "5", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "140.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12898", "Field2": "Морской коктейль замороженный", "Field3": "Китай", "Field4": "70", "Field5": "14", "Field6": "1", "Field7": "1", "Field8": "<p>кальмар полоски, кальмар щупальца, креветки, осьминог, мидии.<\/p>", "Field9": "Рыба и морепродукты", "Field10": "450.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12878", "Field2": "Горбуша горячего копчения", "Field3": "Россия", "Field4": "161", "Field5": "23", "Field6": "8", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12882", "Field2": "Лещ горячего копчения", "Field3": "Россия", "Field4": "172", "Field5": "33", "Field6": "5", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "180.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12873", "Field2": "Сельдь холодного копчения", "Field3": "Норвегия", "Field4": "217", "Field5": "25", "Field6": "12", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "150.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12871", "Field2": "Скумбрия холодного копчения", "Field3": "Норвегия", "Field4": "150", "Field5": "23", "Field6": "6", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "288.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12875", "Field2": "Зубатка пестрая горячего копчения", "Field3": "Норвегия", "Field4": "130", "Field5": "20", "Field6": "5", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "520.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12863", "Field2": "Филе лосося слабой соли в вакуумной упаковке", "Field3": "Норвегия", "Field4": "233", "Field5": "21", "Field6": "16", "Field7": "1", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С.", "Field9": "Рыба и морепродукты", "Field10": "1870.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12901", "Field2": "Угорь унаги свежемороженный", "Field3": "Южная Корея", "Field4": "220", "Field5": "28", "Field6": "17", "Field7": "3", "Field8": "<p>угорь жареный, соевый соус, кукурузный крахмал, сахар, кукурузный сироп.<\/p>", "Field9": "Рыба и морепродукты", "Field10": "1100.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12868", "Field2": "Горбуша тушка холодного копчения", "Field3": "Россия", "Field4": "174", "Field5": "21", "Field6": "10", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12902", "Field2": "Лангустины креветки без головы свежемороженные", "Field3": "Аргентина", "Field4": "112", "Field5": "20", "Field6": "2", "Field7": "2", "Field9": "Рыба и морепродукты", "Field10": "2550.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12877", "Field2": "Масляная рыба, тушка горячего копчения", "Field3": "Норвегия", "Field4": "180", "Field5": "18", "Field6": "12", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "1400.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12874", "Field2": "Филе масляной рыбы холодного копчения", "Field3": "Норвегия", "Field4": "180", "Field5": "18", "Field6": "12", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "1207.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12872", "Field2": "Филе лосося пластинами холодного копчения", "Field3": "Норвегия", "Field4": "179", "Field5": "20", "Field6": "10", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "2200.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12819", "Field2": "Филе лосося свежемороженное в вакуумной упаковке", "Field3": "Норвегия", "Field4": "142", "Field5": "20", "Field6": "6", "Field7": "0", "Field8": "Срок годности: 18 суток при t от -4 до 8С, 150 суток при t -18С.", "Field9": "Рыба и морепродукты", "Field10": "1496.00", "Field11": "1", "Field12": "31700" }, "geometry": null }
        ]
      }');
      
      $content = "";

      foreach ($data->features as $key => $item) {
        $v = $item->properties;

        if($v->Field1 == '(Click to sort Ascending)') continue;


        if('name' == 'name'){
          $name = 'Field2';
          $len = iconv_strlen($v->$name);
          if($len > 79){
            dump($v->$name);
            continue;
          } 
          for ($i=0; $i < (80 - $len); $i++) { 
            $v->$name .= ' ';
          }
        }

        //Set button
        if('button' == 'button'){
          $button = $key+1;
          $len = iconv_strlen($button);
          $pre_button = '';
          for ($i=0; $i < (15 - $len); $i++) { 
            $pre_button .= '0';
          }
          $button = $pre_button . $button;
        }

        //set price
        if('price' == 'price'){
          $price = 'Field10';
          $unit = 'Field11';

          $price_full = number_format((float)((1 / $v->$unit) * $v->$price), 2, '.', '');
          $len = iconv_strlen($price_full);
          $pre = '';
          for ($i=0; $i < (8 - $len); $i++) { 
            $pre .= '0';
          }
          $price_full = $pre . $price_full;
        }
                
        $pa1 = 'A220000100000';
        $pa2_button = $button;
        $pa3 = '0001000100';
        $pa4_price = $price_full;
        $pa5_days = '000';
        $pa6 = '0000';
        $pa7_name = $v->$name;
        $pa8 = "\r\n";

        $string = $pa1.$pa2_button.$pa3.$pa4_price.$pa5_days.$pa6.$pa7_name.$pa8;

        $content .= $string;

        //set country
        if('country' == 'country'){
          $country = 'Field3';
          if(isset($v->$country)) {

            $val = 'Страна: ' . $v->$country;
            $len = iconv_strlen($val);
            if($len > 48){
              dump('bad country', $v);
              continue;
            }

            $len = iconv_strlen($val);
            // for ($i=0; $i < (100 - $len); $i++) { 
            //   $val .= ' ';
            // }

            $ipa1 = 'I';
            $ipa2_button = $button;
            $ipa3_text = $val;
            $ipa4 = "";
            $add = $ipa1.$ipa2_button.$ipa3_text.$ipa4;

            
            $content .= $add;
          }
        }

        //Ccal
        if('ccal' == 'ccal'){
    
          $name = 'Field4';
          if(isset($v->$name)){
            $val = 'Калории: ' . $v->$name;
            $len = iconv_strlen($val);
            if($len > 48){
              dump('bad Калории', $val);
              continue;
            }
    
            $ipa1 = 'I';
            $ipa2_button = $button;
            $ipa3_text = $val;
            $ipa4 = "";
            $add = $ipa3_text.$ipa4;

            
            $content .= $add;
          }
        }   

          
        //Бжу
        if('Бжу' == 'Бжу'){
          $prots = 'Field5';
          $fats = 'Field6';
          $carbs = 'Field7';

          if(isset($v->$prots) && isset($v->$fats) && isset($v->$carbs)){

            $val = "БЖУ: {$v->$prots}/{$v->$fats}/{$v->$carbs}" ;
            $len = iconv_strlen($val);
            if($len > 48){
              dump('bad БЖУ', $v, $val);
              continue;
            }
                            
            $ipa1 = 'I';
            $ipa2_button = $button;
            $ipa3_text = $val;
            $ipa4 = "";
            $add = $ipa3_text.$ipa4;
            
            $content .= $add;
          }
        }   

        //srok
        if('srok' == 'srok'){
          $name = 'Field8';

          if(isset($v->$name)){

            $val = $v->$name;
            $len = iconv_strlen($val);
            $more_sostav = [];
            if($len > 48){
              $left = $val;
              do{                
                $str = mb_substr  ( $left , 0, 45 );
                $left = mb_substr  ( $left , 45 );                
                array_push($more_sostav,$str);                
                if($left == FALSE ) break;
              }while(1);
              
              if(count($more_sostav) > 5){
                dump('bad Состав', $val);
                continue;
              }
            }

            if(count($more_sostav) == 0){
              $more_sostav[1] = $val;
            }

            foreach ($more_sostav as $key => $val) {      
              $ipa3_text = $val;
              $ipa4 = "";
              $add = $ipa3_text.$ipa4;
              
              $content .= $add;
            }   
                      
          }
        }   

          
        

    
        $content .= "\r\n";
      


      }



      Storage::disk('local')->put('up100.txt', mb_convert_encoding($content, "cp866"));

      dd($content);
    
        


    });

    //User    
    Route::get('/login/as/user', 'UserController@loginAsUser');  

    //Delivery    
    Route::get('/json/deliveries', 'DeliveryController@jsonGet');  
    Route::put('/put/delivery', 'DeliveryController@put');      
    Route::delete('/delivery', 'DeliveryController@delete');
    //Pay
    Route::get('/json/pay/methods', 'PayController@getMethods');
    //Return Item
    Route::put('/return/item', 'ReturnItemController@put');      
    Route::delete('/return/item', 'ReturnItemController@delete');     

    //Gruzka
    Route::put('/gruzka/confirm', 'GruzkaController@confirm');
    Route::put('/gruzka/noitem', 'GruzkaController@noItem');
    Route::put('/gruzka/done', 'GruzkaController@done');


    //Items    
    Route::get('/json/items', 'ItemController@jsonGet');    //  
    Route::get('/json/item/statuses', 'ItemStatusController@jsonGetStatuses');
    Route::delete('/item', 'ItemController@delete');
    Route::post('/item', 'ItemController@post');

    //Bonus
    Route::put('/bonus/add', 'BonusController@add');
    
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

 

    //     //Confirm
    //     Route::get('/to/confirm/orders', 'OrderController@getToConfirmOrders');


    //     //Statistics
    //     Route::get('/json/statistics', 'StatisticController@jsonGet');



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
