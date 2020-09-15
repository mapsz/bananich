<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\BonusAdd;
use App\BonusRemove;

class Bonus extends Model
{
  public $guarded = [];
  protected $keys = [
    ['key'    => 'id','label' => '#'],
    ['key'    => 'bonus_type','label' => 'тип'],
    ['key'    => 'quantity','label' => 'количество'],
    ['key'    => 'left','label' => 'осталось'],
    ['key'    => 'user.name','label' => 'пользователь'],
    ['key'    => 'action_user.name','label' => 'исполнитель'],
    ['key'    => 'created_at','label' => 'дата'],
  ];

  public static function getWithOptions($request = null){

    //Query
    $query = new Bonus;

    //Add type
    $query = $query->join('bonus_types', 'bonuses.bonus_type_id', '=', 'bonus_types.id');
    $query = $query->select('bonuses.*', 'bonus_types.name as bonus_type');

    //Add users
    $query = $query->with('user');
    $query = $query->with('action_user');

    //Sort
    $query = $query->orderBy('created_at', 'DESC');

    //Bonus
    $bonus = $query->get();


    return $bonus;
  }

  public static function add($userId, $quantity, $type, $order = null, $comment = null, $dieDays = false){

    //Decode type
    if($type == 'buy') $type = 2;

    try {
      //Start DB
      DB::beginTransaction();

      //Get Left
      $currentCount = Bonus::left($userId);

      // Get action user
      $user = Auth::user();
      $user ? $actionUserId = $user->id : $actionUserId = null;

      //Put Bonus
      $bonus = new Bonus;      
      $bonus->action_user_id = $actionUserId;      
      $bonus->bonus_type_id = $type;
      $bonus->user_id = $userId;
      $bonus->quantity = $quantity;
      $bonus->left = $currentCount + $quantity;
      $bonus->save();

      //Get die date
      $dieDate = self::getDieDate($type,$dieDays);
      if(!$dieDate){
        DB::rollback();
        return response(['code' => 'bo2','text' => 'Bonus type get error'], 512)->header('Content-Type', 'text/plain');
      }

      //Put Bonus Add
      $bonusAdd = new BonusAdd;
      $bonusAdd->bonus_id = $bonus->id;
      $bonusAdd->die = $dieDate;
      $bonusAdd->left = $quantity;
      $bonusAdd->save();

      //Attach order
      if($order) $bonus->order()->attach($order);      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'bo1','text' => 'Bonus add put error'], 512)->header('Content-Type', 'text/plain');
    }
    
  }

  public static function cancelOrderBonus($orderId){

    $bonusesList = DB::table('bonus_order')->where('order_id',$orderId);

    foreach ($bonusesList->get() as $bonus) {
      DB::table('bonus_comments')->where('bonus_id',$bonus->bonus_id)->delete();
      DB::table('bonus_adds')->where('bonus_id',$bonus->bonus_id)->delete();
      DB::table('bonuses')->where('id',$bonus->bonus_id)->delete();
    }

    $bonusesList->delete();

    return;

  }

  public static function getDieDate($type,$dieDays = false){
    //Get die date
    switch ($type) {
      case 1:
        if(!$dieDays) return false;
        $dieDays = $dieDays; //@@@ add current admin
        break;

      default:
        $dieDays = DB::table('bonus_types')->where('id',2)->first()->die;
        break;
    }

    $dieDate = now()->addDays($dieDays);

    return $dieDate;

  }

  public static function remove($userId, $quantity, $type, $comment = null){

    try {
      //Start DB
      DB::beginTransaction();

      //Get Left
      $currentCount = Bonus::left($userId);

      // Get action user
      $user = Auth::user();
      $user ? $actionUserId = $user->id : $actionUserId = null;
      
      //Put Bonus
      $bonus = new Bonus;      
      $bonus->action_user_id = $actionUserId;
      $bonus->user_id = $userId;
      $add->bonus_type_id = $type;
      $bonus->quantity = $quantity;
      $bonus->left = $currentCount - $quantity;
      $bonus->save();

      //Store to DB
      DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'bo4','text' => 'Bonus remove put error'], 512)->header('Content-Type', 'text/plain');
    }

  }

  public static function left($userId){
    $bonus = Bonus::where('user_id',$userId)->latest()->first();
    ($bonus == null || $bonus->count() == 0) ? $currentCount = 0 : $currentCount = $bonus->left;
    return $currentCount;
  }

  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public function jugeGet($request) {return $this->getWithOptions($request);}

  //Relations
  public function order(){
    return $this->belongsToMany('App\Order');
  }
  public function user(){
    return $this->belongsTo('App\User','user_id');
  }
  public function action_user(){
    return $this->belongsTo('App\User','action_user_id');
  }
}