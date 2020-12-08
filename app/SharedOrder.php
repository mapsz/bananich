<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\JugeCRUD;
use App\Address;
use App\SharedOrderContact;
use Carbon\Carbon;

class SharedOrder extends Model
{

  public $guarded = [];
  public $test = true;

  public static function open($data){

    {//Data
      $user = Auth::user();
      $link = SharedOrder::generateLink();
    }

    if(!$user) return false;

    try{
      DB::beginTransaction();{

        {//Put
          $sOrder = new SharedOrder;
          $sOrder->owner_id = $user->id;
          $sOrder->member_count = $data['memberCount'];
          $sOrder->link = $link;
          $sOrder->delivery_date      = $data['date'];
          $sOrder->delivery_time_from = $data['time']['from'];
          $sOrder->delivery_time_to   = $data['time']['to'];
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
        SharedOrder::changeStatus($sOrder,200,$user->id);

        //Attach owner    
        SharedOrder::join($user, false, $sOrder);

      }DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'so1','text' => 'error open shared order'], 512)->header('Content-Type', 'text/plain');
    }
    
    return $sOrder;
  }

  public static function join($user, $link = false, $sOrder = false){

    //Get order
    if(!$sOrder){$sOrder = SharedOrder::where('link',$link)->with('users')->first();}
    $slot = count($sOrder->users) + 1;

    if($slot > $sOrder->member_count){return false;} //TODO @@@ to validate

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

      }DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'so2','text' => 'error attach user'], 512)->header('Content-Type', 'text/plain');
    }

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

  public function jugeGet($request = []) {

    //Model
    $query = new self;
  
    {//With
      $query = $query->with('users');
      $query = $query->with('status');
      $query = $query->with('address');
      $query = $query->with('comment');
      $query = $query->with('pays');
    }
  
    {//Where
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

    }
  
    //Get
    $data = JugeCRUD::get($query,$request);

    
    {//After Query

      //Get settings
      $settings = (new Setting)->getList(1);
             
      //Loop
      foreach ($data as $key => $row) {        
        {//Weight
          $row['full_weight'] = $settings['x_order_weight'];
          $row['user_weight'] = round($settings['x_order_weight'] / $row->member_count, 2, PHP_ROUND_HALF_DOWN);
        }
        {//Price
          $row['full_price'] = $settings['x_order_price'];
          $row['user_price'] = round($settings['x_order_price'] / $row->member_count, 2, PHP_ROUND_HALF_DOWN);
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
        {//User slot
          foreach ($row->users as $user) {
            $user['slot'] = $user->pivot->slot;
          }
        }
      }

    }
  
    //Single
    if(isset($request['id'])){$data = $data[0];}
  
    //Return
    return $data;
  }

  private static function generateLink(){

    //TODO@@@ check exist
    return (new \PragmaRX\Random\Random())->size(9)->get();
  }

  public function handle($request = []){

    $orders = $this->jugeGet(['status' => [200,300]]);

    foreach ($orders as $key => $order) {      
      {//Timers
        $time = now();
        if($this->test)$time = $order['test_time'];

        //Close Pay
        if($time > $order['pay_close'] && $order->status_id != 300){
          //Not Payed
          if($order['full_price'] - $order['payed'] > 5){
            SharedOrder::changeStatus($order->id, -1);
            continue;
          }
          SharedOrder::changeStatus($order->id,300);          
        }

        //Close order
        if($time > $order['order_close']){
          dump('order closed ' . $order->id);
          SharedOrder::changeStatus($order->id,500);
        }

      }
    }

  }

  private static function editContacts(){
    //
  }

  
  //Relations
  public function users(){
    return $this->belongsToMany('App\User','shared_order_user','shared_order_id','user_id')->withPivot('slot');
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
