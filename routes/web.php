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
*/


Route::get('/test/test', function(){

//

});

//Auth
Auth::routes();

//Errors
Route::put('/error', 'ErrorController@put');

//Get auth user
Route::get('/auth/user', 'UserController@getAuthUser');

Route::get('/zakupka', function () {
    return view('main');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/json/items', 'ItemController@jsonGet');

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {

    //Return Item
    Route::put('/return/item', 'ReturnItemController@put');      
    Route::delete('/return/item', 'ReturnItemController@delete');      

    //Confirm
    Route::get('/to/confirm/orders', 'OrderController@getToConfirmOrders');

    //Pay
    Route::get('/json/pay/methods', 'PayController@getMethods');

    //Delivery    
    Route::get('/json/deliveries', 'DeliveryController@jsonGet');  
    Route::put('/put/delivery', 'DeliveryController@put');      
    Route::delete('/delivery', 'DeliveryController@delete');      

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

    //Supplier
    Route::get('/json/suppliers', 'SupplierController@jsonGet');
    Route::get('/json/suppliers/distinct', 'SupplierController@jsonDistinct');
    Route::put('/put/supplier', 'SupplierController@put');
    Route::post('/post/supplier', 'SupplierController@post');
    Route::delete('/delete/supplier', 'SupplierController@delete');
    Route::put('/attach/supplier/product', 'SupplierController@addProduct');
    Route::delete('/remove/supplier/product', 'SupplierController@removeProduct');
    Route::post('/edit/supplier/product/id', 'SupplierController@editId');

    //Goods
    Route::get('/json/goods', 'GoodsController@jsonGet');
    Route::put('/put/goods', 'GoodsController@put');
    Route::post('/post/goods', 'GoodsController@post');
    Route::delete('/delete/goods', 'GoodsController@delete');

    //Statistics
    Route::get('/json/statistics', 'StatisticController@jsonGet');

    //Config List
    Route::get('/config', 'ListConfigController@get');
    Route::post('/config/post', 'ListConfigController@post');

    //Gruzka
    Route::put('/gruzka/confirm', 'GruzkaController@confirm');
    Route::put('/gruzka/noitem', 'GruzkaController@noItem');
    Route::put('/gruzka/done', 'GruzkaController@done');

    //Permissions
    // Route::get('/', 'PermissionController@redirect');

    //User
    Route::put('/user', 'UserController@put');
    Route::get('/json/users', 'UserController@jsonGet');

    //Auto gruzka
    Route::get('/gruzka/auto/order', 'OrderController@autoOrder');

    //Item quantity update
    Route::post('/item/quantity', 'ItemController@quantityUpdate');
    Route::put('/item/status', 'ItemStatusController@putStatus');

    //Parse
    Route::get('/parse/orders', 'ParseController@getOrders');
    Route::get('/parse/product/by/name', 'ParseController@parseProductByName');

    //Order
    Route::get('/json/orders', 'OrderController@jsonGet');
    Route::post('/order', 'OrderController@post');
    Route::put('/order/item', 'OrderController@addItem');

    //Order Status
    Route::get('/json/order/statuses', 'OrderStatusController@jsonGetStatuses');
    Route::put('/order/status', 'OrderStatusController@putStatus');

    //Item
    Route::get('/json/item/statuses', 'ItemStatusController@jsonGetStatuses');
    Route::delete('/item', 'ItemController@delete');
    Route::post('/item', 'ItemController@post');

    //Container
    Route::put('/container', 'ContainerController@put');
    Route::delete('/container', 'ContainerController@delete');
    Route::get('/json/containers', 'ContainerController@jsonGet');
    Route::put('/container/attach', 'ContainerController@attach');
    
    //File upload
    Route::post('/file/upload', 'FileUploadController@fileUpload');

    // Product
    Route::put('/product', 'ProductController@put');
    Route::post('/product', 'ProductController@post');
    Route::get('/json/products', 'ProductController@get');
    Route::get('/base64/preloaded/images', 'ProductController@getBase64PreloadedImages');

    //Discount
    Route::delete('/discount/remove', 'DiscountController@remove');
    Route::put('/discount/add', 'DiscountController@add');

    // Route::get('/home', function(){
    //     return view('main');
    // })->name('home');

    

    Route::get('/home', function(){
        return redirect('/');
    });    
    
    Route::get('/main', function(){
        return redirect('/');
    });

    Route::get('/{vue_capture?}', function () {
        return view('main');
    })->where('vue_capture', '[\/\w\.-]*');

    


});