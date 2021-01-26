<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\JugeCRUD;
use App\Address;
use App\SharedOrderContact;
use App\Announce;
use Carbon\Carbon;
class SharedOrder extends Model
{

  public $guarded = [];
  public $test = false;

  public static function open($data){

    //Cart
    $cart = Cart::getCart(['type' => 'x']);

    //Validate
    SharedOrder::validate($data, true, $cart);

    {//Data
      $user = Auth::user();
      $link = SharedOrder::generateLink();
    }

    if(!$user) return false;

    {//DB
      try{
        DB::beginTransaction();{
  
          {//Put
            $sOrder = new SharedOrder;
            $sOrder->id = self::generateRandomId();
            $sOrder->owner_id = $user->id;
            $sOrder->member_count = $data['memberCount'];
            $sOrder->link = $link;
            $sOrder->delivery_date      = $data['date'];
            $sOrder->delivery_time_from = $data['time']['from'] . ":00:00";
            $sOrder->delivery_time_to   = $data['time']['to'] . ":00:00";
            $sOrder->save();            
          }
          
          {//Attach Address
            $address = [
              'street' => $data['address']['addressStreet'],
              'number' => isset($data['address']['addressNumber']) ? $data['address']['addressNumber'] : null,
              'appart' => isset($data['address']['addressApart']) ? $data['address']['addressApart'] : null,
              'porch' => isset($data['address']['addressPorch']) ? $data['address']['addressPorch'] : null,
              'stage' => isset($data['address']['addressStage']) ? $data['address']['addressStage'] : null,
            ];
            $sOrder->address()->save(new Address($address));
          }
                  
          {//Attach Comment
            if(isset($data['comment']) && $data['comment']){
              $sOrder->comment()->save(new Comment(['body' => $data['comment']]));
            }          
          }
  
          //Attach status
          SharedOrder::changeStatus($sOrder, 200, $user->id);
  
          //Attach owner    
          $neighbor = isset($data['neighbor']) && $data['neighbor'] ? true : false;
          SharedOrder::join($user, false, $sOrder, $neighbor, $cart);
  
        }DB::commit();    
      } catch (Exception $e){
        // Rollback from DB
        DB::rollback();
        return response(['code' => 'so1','text' => 'error open shared order'], 512)->header('Content-Type', 'text/plain');
      }
    }
    
    
    return $sOrder;
  }

  public static function edit($data){

    //is editable    
    $sOrder = (new SharedOrder)->jugeGet(['id' => $data['id']]);
    if(!isset($sOrder->editable) || !$sOrder->editable) return false;

    //Validate
    SharedOrder::validate($data, false);

    //Get order
    $sOrder = SharedOrder::find($data['id']);   

    {//Set data
      {//Shared order
        $sOrderData = [];
        if(isset($data['memberCount'])) $sOrderData['member_count'] = $data['memberCount'];
        if(isset($data['date'])) $sOrderData['delivery_date'] = $data['date'];
        if( (isset($data['time']) && isset($data['time']['from'])) && (isset($data['time']) && isset($data['time']['to'])) ){
          $sOrderData['delivery_time_from'] = $data['time']['from'] . ':00:00';
          $sOrderData['delivery_time_to'] = $data['time']['to'] . ':00:00';
        } 
      }

      {//Address
        if(isset($data['address']) && is_array($data['address'])){
          $addressData = [];
          if(array_key_exists('addressStreet', $data['address'])) $addressData['street'] = $data['address']['addressStreet'];
          if(array_key_exists('addressNumber', $data['address'])) $addressData['number'] = $data['address']['addressNumber'];
          if(array_key_exists('addressApart', $data['address'])) $addressData['appart'] = $data['address']['addressApart'];
          if(array_key_exists('addressPorch', $data['address'])) $addressData['porch'] = $data['address']['addressPorch'];
        }
      }

    }

    {//Update
      {//Address
        if(count($addressData) > 0){
          //Delete old
          Address::where('addressable_type', 'App\SharedOrder')->where('addressable_id', $data['id'])->delete();
          //Add new
          $sOrder->address()->save(new Address($addressData));          
        }
      }


      {//Comment
        if(isset($data['comment']) || $data['comment'] === null){
          //Delete old
          Comment::where('commentable_type', 'App\SharedOrder')->where('commentable_id', $data['id'])->delete();
          //Add new
          if($data['comment']){
            $sOrder->comment()->save(new Comment(['body' => $data['comment']]));
          }
        }
      }

      {//Shared order
        $sOrder = $sOrder->update($sOrderData);
      }
    }

    return true;

  }
  
  public static function validate($data, $put=false, $cart=false){

    {//Params
      //Settings
      $settings = (new Setting())->getList(1);
    }

    {//Validate

      {//Validate Shared Order
        
        {//Required
          if($put){
            $validate = [
              'address.addressStreet'       => ['required'],          
              'memberCount'                 => ['required'],
              'date'                        => ['required'],
              'time'                        => ['required'],
            ];

            $messages = [
              'address.addressStreet.required'      => 'Необходимо заполнить поле "Адрес"',
              'memberCount.required'                => 'Необходимо выбрать количество участников',
              'date.required'                       => 'Необходимо выбрать время доставки',
              'time.required'                       => 'Необходимо выбрать дату доставки',
            ];

            Validator::make($data, $validate,$messages)->validate();
          }
        }

        {//Other
          $validate = [
            'address.addressStreet'       => 'bail|string|min:5|max:170',
            'memberCount'                 => ['min:1', "max:{$settings['x_max_member_count']}"],
            'address.addressApart'        => ['max:20' ],
            'address.addressNumber'       => ['max:20' ],
            'address.addressPorch'        => ['max:20' ],
            'comment'                     => ['max:1000'],
          ];

          $messages = [
            'address.addressStreet.string'        => 'Необходимо заполнить поле "Адрес"',
            'address.addressStreet.min'           => 'Количество символов в поле "Адрес" не должно быть меньше :min',
            'address.addressStreet.max'           => 'Количество символов в поле "Адрес" не должно превышать :max',
            'address.addressPorch.max'            => 'Количество символов в поле "Этаж" не должно превышать :max',
            'address.addressNumber.max'           => 'Количество символов в поле "Дом" не должно превышать :max',
            'address.addressApart.max'            => 'Количество символов в поле "Квартира" не должно превышать :max',
            'comment.max'                         => 'Количество символов в поле "Комментарий" не должно превышать :max',
          ];

          Validator::make($data, $validate,$messages)->validate();
        }
        
      }
      
      {//Validate Available Days
        $date = Carbon::parse($data['date'])->format('Y-m-d');
        $time = $data['time'];
        
        {//Past date
          $checkAvailableDayse = true;
          if(isset($data['id'])){
            $sOrder = SharedOrder::find($data['id']);
            if(isset($data['date']) && isset($data['time']) && isset($data['time']['from']) && isset($data['time']['to'])){
              //Check if order date choosed
              if(
                $sOrder['delivery_date'] == $data['date'] &&
                str_replace(':00:00','',$sOrder['delivery_time_from'])  == $data['time']['from'] &&
                str_replace(':00:00','',$sOrder['delivery_time_to'])    == $data['time']['to']              
              ){
                $checkAvailableDayse = false;
              }
            }
            
          }
        }

        if($checkAvailableDayse) Order::validateAvailableDays($date,$time,'x');
      }

      {//Validate available product
        if($put){
          if(!$cart) $cart = Cart::getCart(['type' => 'x']);          
          Order::validateAvailableProducts($cart);
        }       
      }
      
    }
  }

  public static function join($user, $link = false, $sOrder = false, $neighbor = false, $cart = false){
    
    //Get order
    if(!$sOrder) $sOrder = (new SharedOrder)->jugeGet(['link' => $link,'single' => 1, 'noHandle' => true]);
    $slot = count($sOrder->users) + 1;

    try{
      DB::beginTransaction();{
        
      // Attach user      
      $sOrder->users()->attach($user->id,['slot' => $slot]);
      
      {//Attach Contacts
        $sOrderContact = new SharedOrderContact;
        $sOrderContact->name              = isset($user->name) ? $user->name : 'none';
        $sOrderContact->phone             = isset($user->phone) ? $user->phone : 'none';
        $sOrderContact->email             = isset($user->email) ? $user->email : 'none';
        $sOrderContact->user_id           = $user->id;
        $sOrderContact->shared_order_id   = $sOrder->id;
        $sOrderContact->save();
      }

      {//Make Personal Order
        {//Form data
          $data['id'] = $sOrder['id'] . '0' . $slot;
          $data['deliveryDate'] = $sOrder['delivery_date'];
          $data['deliveryTime']['from'] = str_replace (':00:00','',$sOrder->delivery_time_from);
          $data['deliveryTime']['to'] = str_replace (':00:00','',$sOrder->delivery_time_to);
          $data['payMethod'] = 0;
          $data['confirm'] = 1;
          $data['comment'] = "";
          $data['name'] = $user->name;
          $data['phone'] = $user->phone;
          $data['email'] = $user->email;
          $data['addressStreet'] = $sOrder->address->street;
          $data['addressNumber'] = $sOrder->address->number;
          $data['addressApart'] = $sOrder->address->appart;
          $data['addressPorch'] = $sOrder->address->porch;
          $data['type'] = 'x';
        }

        //Put
        $order = Order::putOrder($data, 0, 0, 950);

        //Neighbor
        if($neighbor){
          DB::table('order_metas')->insert(['order_id'=>$order->id, 'name'=>'neighbor', 'value'=>1]);
        }

        //Attach
        $sOrder->orders()->attach($order->id);

      }

      }DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'so2','text' => 'error attach user'], 512)->header('Content-Type', 'text/plain');
    }

    
    {//Announces
      $sOrder = (new SharedOrder)->with('users')->where('link', $link)->first();    
      if(count($sOrder->users) > 1){
        foreach ($sOrder->users as $key => $oUser) {
          if($user->id == $oUser->id) continue;
          Announce::add($oUser->id,'join',[['tag'=> 'order_link','value'=>$sOrder->link]]);
        }
      }
    }
    
    //Sync order
    Order::syncCartOrder($cart);

    return true;
  }

  public static function kick($sOrderId, $userId){

    //Get shared order
    $sOrder = SharedOrder::where('id', $sOrderId)->first();

    {//Order
      $order = (
        Order::
        whereHas('sharedOrder', function($q)use($sOrderId){
          $q->where('shared_orders.id', '=', $sOrderId);
        })
        ->where('customer_id', '=', $userId)
        ->first()
      );
 

      //Cancel
      Order::changeStatus($order->id,0);

      //Detach
      $order->sharedOrder()->detach($sOrderId);

      //Delete
      $order->delete();
    }

    {//User
      $sOrder->users()->detach($userId);
    }

    //Announce
    $currentUser = Auth::user();
    if($userId != $currentUser->id){
      Announce::add($userId,'kicked',[['tag'=> 'order_link','value'=>$sOrder->link]]);
    }
    if($userId == $currentUser->id){
      foreach ($sOrder->users as $key => $oUser) {
        if($oUser->id == $currentUser->id) continue;
        Announce::add($oUser->id,'left',[['tag'=> 'order_link','value'=>$sOrder->link]]);
      }
    }    

    return true;

  }

  public static function cancel($id){
    //TODO @@@ красивей

    $sOrder = (new SharedOrder)->jugeGet(['id' => $id,'single' => 1]);

    foreach ($sOrder->orders as $key => $order) {
      Order::changeStatus($order->id,0);
    }

    self::changeStatus($id,0);

    return true;

  }

  public static function changeStatus($sOrder, $statusId, $userId = false){
    
    if(is_int($sOrder)){
      $sOrder = SharedOrder::where('id',$sOrder)->first();
    }

    {// Shared order post
      $sOrder->status_id = $statusId;
      $sOrder->save();
    }

    {//Attach status      
      {//Set user
        if($userId == false){
          $user = Auth::user();
          if($user){
            $userId = Auth::user()->id;
          }
        }
        $data = [];
        if($userId){
          $data['user_id'] = $userId;
        }
      }
      $sOrder->statuses()->attach(100, $data);
    }



  }

  private static function generateLink(){
    do{
      $link = (new \PragmaRX\Random\Random())->size(9)->get();
    }while(SharedOrder::where('link', $link)->exists());
    return $link;
  }

  public function handle($request = []){

    $orders = $this->jugeGet(['status' => [200,300], 'noHandle' => true]);

    foreach ($orders as $key => $order) {
      {//Timers
        $time = now();
        if($this->test) $time = $order['test_time'];

        //Close Pay
        // if($time > $order['pay_close'] && $order->status_id != 300){
        //   //Not Payed
        //   if($order['full_price'] - $order['payed'] > 5){
        //     SharedOrder::changeStatus($order->id, -1);
        //     continue;
        //   }
        //   SharedOrder::changeStatus($order->id,300);          
        // }

        //Close order
        if($time > $order['order_close']){
          // dump('order closed ' . $order->id);
          //Lock order
          SharedOrder::lock($order->id);
        }

      }
    }

  }

  public static function lock($id){

    // dd($id);
    
    //Sync order
    Order::syncCartOrder();
    
    {//Shared
      // //Get
      $sOrder = (new SharedOrder)->jugeGet(['id' => $id,'single' => 1, 'noHandle' => true]);
      // //Change status
      SharedOrder::changeStatus($id,500);
    }

    
    {//Personal
      $member_count = 0;
      foreach ($sOrder->orders as $order) {
        //Update date/time
        $update = Order::find($order->id)->update([
          'delivery_date'         => $sOrder->delivery_date,
          'delivery_time_from'    => $sOrder->delivery_time_from,
          'delivery_time_to'      => $sOrder->delivery_time_to,
        ]);
                
        //Update status
        if($order->x_confirm){
          $statusId = 900;
          $member_count++;
        }else{
          $statusId = 0;
        }
        $statusId = $order->x_confirm ? 900 : 0;
        Order::changeStatus($order->id, $statusId);
      }
    }    

    
    {//Update member count
      $member_count = count($sOrder->users);
      SharedOrder::where('id',$id)->update(['member_count' => $member_count]);      
    }

    {//Delete carts
      foreach ($sOrder->users as $key => $user) {
        Cart::where('user_id',$user->id)->where('type',2)->delete();
      }
    }  
  }

  public static function updateOrders($id){

    $sOrder = (new SharedOrder)->jugeGet(['id' => $id,'single' => 1]);

    if($sOrder->status_id != 200) return false;

    foreach ($sOrder->users as $user) {
      //Get cart
      $cart = Cart::jugeGet(['user' => $user->id,'type' => 'x', 'single' => 1, 'products' => 1]);
      $cart = Checkout::addToCart($cart);
      
      {//Get order
        $order = (
          Order::
          whereHas('sharedOrder', function($q)use($id){
            $q->where('shared_orders.id', '=', $id);
          })
          ->where('customer_id', '=', $user->id)
          ->first()
        );
      }

      //Update items
      Order::putItems($cart, $order->id);

    }

    return true;

  }

  private static function editContacts(){
    //
  }

  public static function byAuth($handle = true){

    $user = Auth::user();    

    if(!$user) return false;

    $sOrder = (new SharedOrder)->jugeGet(['member' => $user->id, 'status' => [200,300],'noHandle' => !$handle]);

    if(isset($sOrder[0])){
      $sOrder = $sOrder[0];
    }

    return $sOrder;
  }

  private static function generateRandomId(){
    
    {//Make id
      $date = now()->format('ymd');
      $random = rand(100,999);
      $id = $date . $random;
    }

    do{//Check exists
      $exists = SharedOrder::where('id',$id)->exists();      
      if($exists){
        //Generate other
        if($random == 999) $random = 99;
        $random++;
        $id = $date . $random;
      }
    }while($exists);

    return $id;

  }

  public function jugeGet($request = []){

    //handle
    if(!isset($request['noHandle'])){
      (new SharedOrder)->handle();
    } 
    
    //Model
    $query = new self;
  
    {//With
      $query = $query->with('users');
      $query = $query->with('status');
      $query = $query->with('address');
      $query = $query->with('comment');
      $query = $query->with('pays');
      // $query = $query->with('orders');
    }
  
    {//Where
      // dd($request);
      if(isset($request['link'])){
        $query = $query->where('link',$request['link']);
      }
      if(isset($request['id'])){
        $query = $query->where('id',$request['id']);
      }
      //Statuses
      if(isset($request['status']) && $request['status'] > -1){
        $statuses = is_array($request['status']) ? $request['status'] : [$request['status']];
        $query = $query->whereIn('status_id',$statuses);
      }
      //Member      
      if(isset($request['member']) && isset($request['member']) > 0){
        $memberId = $request['member'];
        $query = $query->whereHas('users', function($q)use($memberId){
          $q->where('user_id', '=', $memberId);
        });
      }
      //Actual
      if(isset($request['actual']) && $request['actual']){
        $query = $query->where('delivery_date','>',now());
      }

    }

    $query = $query->orderBy('id','DESC');
  
    //Get
    $data = JugeCRUD::get($query,$request);
    
    {//After With
      //Order
      foreach ($data as $key => $row) {  
        $row['orders'] = Order::jugeGet(['sharedOrder' => $row->id]);
      }      
    }
    
    {//After Query

      //Get settings
      $settings = (new Setting)->getList(1);
             
      //Loop
      foreach ($data as $key => $row) {  
        {//Short Address
          $row['short_address'] = $row->address->street . ' ' . $row->address->number;
        }      
        {//Weight
          $row['full_weight'] = $settings['x_order_weight'];
          $row['user_weight'] = round($settings['x_order_weight'] / ($row->member_count == 0 ? 1 : $row->member_count), 2, PHP_ROUND_HALF_DOWN);
        }
        {//Price
          $row['full_price'] = $settings['x_order_price'];
          $row['user_price'] = round($settings['x_order_price'] / ($row->member_count == 0 ? 1 : $row->member_count), 2, PHP_ROUND_HALF_DOWN);
          //Payed
          $row['payed'] = 0;
          foreach ($row->pays as $pay) {
            $row['payed'] += $pay->amount;
          }
        }
        {//Close time
          if($this->test){
            $test_time = DB::table('shared_order_test_time')->where('shared_order_id',$row->id)->first();            
            $row['test_time'] = now();
            if($test_time){
              $row['test_time'] = $row['test_time']->addMinutes($test_time->minutes);
            }
          }
          
          $row['order_close'] = Carbon::parse($row->delivery_date)->subHours($settings['x_order_close_hours']);
          $row['pay_close'] = Carbon::parse($row->delivery_date)->subHours($settings['x_pay_close_hours']);
        }        
        {//Users
          {//Loop
            foreach ($row->users as $user) {
              //Slot
              $user['slot'] = $user->pivot->slot;              
              //Main_Images
              $user->mainImage = User::getMainImage($user->id);   
            }
          }
        }
        {//Editable
          $row['editable'] = false;
          if(count($row->users) < 2 && ($row->status_id == 100 || $row->status_id == 200)){
            $row['editable'] = true;
          }
        }
        {//Joinable
          $row['joinable'] = false;
          if(
            ($row->status_id == 100 || $row->status_id == 200) && 
            (count($row->users) < $row->member_count)
          ){
            $row['joinable'] = true;
          }
        }
      }

    }
  
    //Single
    if((isset($request['id']) || isset($request['single']) && isset($data[0]))){$data = $data[0];}

    
    //Return
    return $data;
  }
  
  //Relations
  public function users(){
    return $this->belongsToMany('App\User','shared_order_user','shared_order_id','user_id')->withPivot('slot');
  }
  public function orders(){
    return $this->belongsToMany('App\Order','shared_order_order','shared_order_id','order_id');
  }
  public function status(){
    return $this->belongsTo('App\SharedOrderStatus');
  }
  public function pays(){
    return $this->hasMany('App\SharedOrderPay');
  }
  public function contacts(){
    return $this->hasMany('App\SharedOrderContact');
  }
  public function statuses(){
    return $this->belongsToMany('App\SharedOrderStatus');
  }
  public function address(){
    return $this->morphOne('App\Address', 'addressable');
  }
  public function comment(){
    return $this->morphOne('App\Comment', 'commentable');
  }


  
  
  
}
