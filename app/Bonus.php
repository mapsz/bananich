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

  public static function add($userId, $quantity, $type, $comment = null, $dieDays = null){

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
      $bonus->quantity = $quantity;
      $bonus->left = $currentCount + $quantity;
      $bonus->save();

      //Get die date
      switch ($type) {
        case 1:
          $dieDays = $dieDays;
          break;
        
        default:
          $dieDays = DB::table('bonus_types')->where('id',2)->first()->die;
          break;
      }
      if($dieDays === null){
        DB::rollback();
        return response(['code' => 'bo2','text' => 'Bonus type get error'], 512)->header('Content-Type', 'text/plain');
      }
      $dieDate = now()->addDays($dieDays);

      //Put Bonus Add
      $add = new BonusAdd;
      $add->bonus_id = $bonus->id;
      $add->bonus_type_id = $type;
      $add->comment = $comment;
      $add->die = $dieDate;
      $add->save();
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'bo1','text' => 'Bonus add put error'], 512)->header('Content-Type', 'text/plain');
    }
    
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
      $bonus->quantity = $quantity;
      $bonus->left = $currentCount - $quantity;
      $bonus->save();

      //Put Bonus Remove
      $add = new BonusRemove;
      $add->bonus_id = $bonus->id;
      $add->bonus_type_id = $type;
      $add->comment = $comment;
      $add->save();      
      
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
    $bonus->count() == 0 ? $currentCount = 0 : $currentCount = $bonus->left;
    return $currentCount;
  }
}
