<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\BonusAdd;
use App\BonusRemove;
use App\BonusComment;

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
    ['key'    => 'comment.comment','label' => 'коммент'],
    ['key'    => 'add_bonus.die','label' => 'Сгорят'],
  ];
  protected $inputs = [
    [
      'name' => 'id',
      'caption' => 'ид пользователя',
      'required' => true,
    ],
    [
      'name' => 'count',
      'caption' => 'количество',
      'required' => true,
    ],
    [
      'name' => 'comment',
      'caption' => 'коммент',
    ],
    [
      'name' => 'dieDays',
      'caption' => 'срок жизни(дни)',
    ],
  ];

  public static function getWithOptions($request = null){

    self::killExpired();
    
    //Query
    $query = new Bonus;

    if('with'=='with'){
      //Add type
      $query = $query->join('bonus_types', 'bonuses.bonus_type_id', '=', 'bonus_types.id');
      $query = $query->select('bonuses.*', 'bonus_types.name as bonus_type');

      //Add users
      $query = $query->with('user');
      $query = $query->with('action_user');
      $query = $query->with('addBonus');
      $query = $query->with('comment');
    }

    if('where'=='where'){
      if(!isset($request['nousernolive'])){ //@@@ защиту?
        $user = Auth::user();
        $userId = $user->id;
      }else{
        $userId = false;
      }

      if(isset($request['user']) && $user->isAdmin()){
        $query = $query->where('user_id', $request['user']);
      }

      if(!isset($request['all_users'])){
        if(!isset($request['user'])){
          $query = $query->whereHas('user', function($q)use($userId){
            $q->where('id', '=', $userId);
          });
        }
      }

      if(isset($request['soonDie'])){
        $query = $query->whereHas('addBonus', function ($q) {
          $q->where('left', '>', '0');
        });
      }
    }


    //Sort
    $query = $query->orderBy('created_at', 'DESC');

    //Bonus
    $bonus = JugeCRUD::get($query,$request);

    


    return $bonus;
  }

  public static function add($userId, $quantity, $type, $order = null, $comment = null, $dieDays = false){

    //Decode type
    if($type == 'buy') $type = 2;

    try{
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

      //Put Bonus Comment
      if($comment){
        $BonusComment = new BonusComment;
        $BonusComment->bonus_id         = $bonus->id;
        $BonusComment->comment          = $comment;
        $BonusComment->save();
      }      


      //Attach order
      if($order) $bonus->order()->attach($order);      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'bo1','text' => 'Bonus add put error'], 512)->header('Content-Type', 'text/plain');
    }

    return true;
    
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

    $default = DB::table('bonus_types')->where('id',2)->first()->die;
    //Get die date
    switch ($type) {
      case 1:
        $dieDays = $dieDays; //@@@ add current admin
        break;

      default:
        $dieDays = $default;
        break;
    }


    if(!$dieDays) $dieDays = $default;
    $dieDate = now()->addDays($dieDays);

    return $dieDate;

  }

  public static function remove($userId, $quantity, $type, $comment = null){

    try {
      //Start DB
      DB::beginTransaction();

      //Get Left
      $currentCount = Bonus::left($userId,false);

      //Get actual bonus adds
      $bonusAdds = (
        Bonus::where('user_id',$userId)
          ->with('addBonus')
          ->whereHas('addBonus', function ($q) {
            $q->where('left', '>', 0);
          })
          ->get()
      );

      //Correct actual bonus adds
      $toRemove = $quantity;
      foreach ($bonusAdds as $key => $bonus) {        
        $bonus->addBonus->left -= $toRemove;
        $toRemove = $bonus->addBonus->left - ($bonus->addBonus->left*2);
        if($bonus->addBonus->left < 0) $bonus->addBonus->left = 0;
        $bonus->addBonus->save();     
        if($toRemove < 1) break;            
      }

      // Get action user
      $user = Auth::user();
      $user ? $actionUserId = $user->id : $actionUserId = null;
      
      //Put Bonus
      $bonus = new Bonus;      
      $bonus->action_user_id = $type == 3 ? null : $actionUserId;
      $bonus->user_id = $userId;
      $bonus->bonus_type_id = $type;
      $bonus->quantity = $quantity;
      $bonus->left = $currentCount - $quantity;
      $bonus->save();

      
      //Put Bonus Comment
      if($comment){
        $BonusComment = new BonusComment;
        $BonusComment->bonus_id  = $bonus->id;
        $BonusComment->comment   = $comment;
        $BonusComment->save();
      }      

      //Store to DB
      DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'bo4','text' => 'Bonus remove put error'], 512)->header('Content-Type', 'text/plain');
    }

  }

  public static function left($userId,$killExpired = true){    
    if($killExpired){Bonus::killExpired();} 
    $bonus = Bonus::where('user_id',$userId)->latest()->first();
    ($bonus == null || $bonus->count() == 0) ? $currentCount = 0 : $currentCount = $bonus->left;
    return $currentCount;
  }

  public static function killExpired(){
    // Get expired
    $expired = BonusAdd::with('bonus')->where('left','>',0)->where('die','<',now())->get();
    if($expired->count() < 1) return false;

    //Remove bonus
    try {      
      foreach ($expired as $key => $bonus) {
        if($bonus->bonus == null){
          Log::info('bonus add have no bonus id-'. $bonus->bonus_id);
          continue;
        }
        Bonus::remove($bonus->bonus->user_id, $bonus->left, 3);        
        $bonus->left = 0;
        $bonus->save();
      }
    } catch (Exception $e){
      return false;
    }    
    
    return true;
  }


  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public function jugeGetInputs()     {return $this->inputs;}  
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
  public function addBonus(){
    return $this->hasOne('App\BonusAdd');
  }
  public function comment(){
    return $this->hasOne('App\BonusComment');
  }
}
