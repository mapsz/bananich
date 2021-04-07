<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Meta;

class Balance extends Model
{

  public $guarded = [];
  protected $keys = [
    ['key'    => 'id','label' => '#'],
    ['key'    => 'quantity','label' => 'количество'],
    ['key'    => 'left','label' => 'осталось'],
    ['key'    => 'user.name','label' => 'пользователь','type' => 'link', 'link' => '/admin/user/{user_id}'],
    ['key'    => 'actionUser.name','label' => 'исполнитель'],
    ['key'    => 'order.id','label' => 'заказ','type' => 'link', 'link' => '/admin/order/{order_id}'],
    ['key'    => 'comment.body','label' => 'коммент'],
    ['key'    => 'created_at','label' => 'дата'],
  ];

  public static function left($userId){
    $lastBalance = Balance::where('user_id', $userId)->orderBy('id','Desc')->first();
    return isset($lastBalance->left) && $lastBalance->left != 0 ? $lastBalance->left : 0;
  }

  public static function editBalance($userId, $quantity, $comment = null, $actionUserId = false, $orderId = false){

    //Get left
    $left = Balance::left($userId);

    try {      
      //Edit Balance
      $balance = new Balance;
      $balance->user_id = $userId;
      $balance->quantity = $quantity;
      $balance->left = $left + $quantity;
      $balance->save();

      //Comment
      if($comment !== null){
        $balance->comment()->save(new Comment(['body' => $comment]));
      }

      //Action user
      if($actionUserId){
        $balance->metas()->save(new Meta(['name' => 'action_user_id', 'value' => $actionUserId]));
      }

      //Order
      if($orderId){
        $balance->metas()->save(new Meta(['name' => 'order_id', 'value' => $orderId]));
      }

    } catch (\Throwable $th) {
      //Log
      JugeLogs::log(9000, json_encode(['model' => 'Balance', 'error' => $th]));
    }

    return $balance;

  }


  public static function jugeGet($request = []) {
    //Model
    $query = new self;
  
    {//With
      $query = $query->with('actionUser');
      $query = $query->with('user');
      $query = $query->with('order');
      $query = $query->with('comment');
    }
  
    {//Where
      //User
      if(isset($request['user_id'])){
        $query = $query->where('user_id', $request['user_id']);
      }      
    }
    
    //Sort
    $query = $query->orderBy('id', 'DESC');
  
    //Get
    $data = JugeCRUD::get($query,$request);

    {//After Query
      foreach ($data as $key => $balance) {        

        {//ActionUser
          if(isset($balance->actionUser[0])){
            $actionUser = $balance->actionUser[0];
            unset($actionUser->pivot);
            unset($balance->actionUser);
            $balance->actionUser = $actionUser;
          }else{
            unset($balance->actionUser);
            $balance->actionUser = null;
          }
        }

        {//Order
          if(isset($balance->order[0])){
            $order = $balance->order[0];
            unset($order->pivot);
            unset($balance->order);
            $balance->order = $order;
          }else{
            unset($balance->order);
            $balance->order = null;
          }
        }
        
      }
    }
  
    //Single
    if(isset($request['id']) && isset($data[0])){$data = $data[0];}
  
    //Return
    return $data;
  }

  public function jugeGetKeys()     {return $this->keys;}  



  public function metas(){
    return $this->morphMany('App\Meta', 'metable');
  }
  public function actionUser(){
    return $this->belongsToMany(User::class, 'metas', 'metable_id', 'value')
        ->where('metable_type', static::class)
        ->where('metas.name', 'action_user_id');
  }
  public function user(){
    return $this->belongsTo('App\User','user_id');
  }
  public function order(){
    return $this->belongsToMany(Order::class, 'metas', 'metable_id', 'value')
        ->where('metable_type', static::class)
        ->where('metas.name', 'order_id');
  }
  public function comment(){
    return $this->morphOne('App\Comment', 'commentable');
  }
}
