<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Coupon;
use App\Meta;
use App\Balance;

class Referral extends Model
{

  public $guarded = [];

  public static function attachCoupon($couponId, $parentId, $reward){

    //Validate
    self::validateToCoupon(['couponId' => $couponId, 'parentId' => $parentId, 'reward' => $reward]);

    //Detach old
    self::dettachCoupon($couponId);

    {//Attach
      //Parent
      Meta::insert([
        'metable_id'    => $couponId,
        'metable_type'  => 'App\Coupon',
        'name'          => 'refferal_parent_id',
        'value'          => $parentId,
      ]);
      //Reward
      Meta::insert([
        'metable_id'    => $couponId,
        'metable_type'  => 'App\Coupon',
        'name'          => 'refferal_reward',
        'value'          => $reward,
      ]);    
    }

    return true;

  }

  public static function dettachCoupon($couponId){

    //Delete parent
    Meta::where('metable_type', 'App\Coupon')
      ->where('metable_id', $couponId)
      ->where('name', 'refferal_parent_id')
      ->delete();

    //Delete reward
    Meta::where('metable_type', 'App\Coupon')
      ->where('metable_id', $couponId)
      ->where('name', 'refferal_reward')
      ->delete();

    return true;

  }

  public static function addCoupon($order, $coupon){
    
    //Add referral
    $reward = Meta::where('metable_id', $coupon->id)->where('metable_type', 'App\Coupon')->where('name', 'refferal_reward')->first()->value;

    $referral = new Referral();
    $referral->referralable_id = $coupon->id;
    $referral->referralable_type = 'App\Coupon';
    $referral->parent_id = $coupon->referralParent->id;
    $referral->child_id = $order->customer_id;
    $referral->reward = $reward;
    $referral->save();


    //Add order
    DB::table('metas')->insert([
      'metable_id' => $referral->id,
      'metable_type' => 'App\Referral',
      'name' => 'order_id',
      'value' => $order->id,
    ]); 

    return true;

  }

  public static function couponSuccess($orderId){

    $ref = Referral::with('metas')
    ->whereHas('metas', function($q)use($orderId){
      $q->where('value',$orderId)
        ->where('metable_type', 'App\Referral')
        ->where('name', 'order_id');
    })->first();

    if(!$ref) return false;
    
    //Edit balance
    Balance::editBalance($ref->parent_id, $ref->reward, "Реферал: $ref->child_id", false, $orderId);

    //Edit status 
    $ref->update(['status' => 1]);

    return true;

  }
  
  public static function couponCancel($orderId){

    $ref = Referral::with('metas')
    ->whereHas('metas', function($q)use($orderId){
      $q->where('value',$orderId)
        ->where('metable_type', 'App\Referral')
        ->where('name', 'order_id');
    })->first();

    if(!$ref) return false;

    //Edit balance
    Balance::editBalance($ref->parent_id, $ref->reward - ($ref->reward*2), "Отмена заказа, реферал: $ref->child_id", false, $orderId);

    //Edit status 
    $ref->update(['status' => 1]);

    return true;

  }

  public static function getUserBalance($userId){

    $referrals = Referral::where('parent_id', $userId)->where('status', 1)->get();

    $balance = 0;
    foreach ($referrals as $key => $referral) {
      $balance += $referral->reward;
    }

    return $balance;

  }


  public static function validateToCoupon($data, $put = false){

    {//Data exists
      $validate = [
        'couponId'        => ['required'],
        'parentId'        => ['required'],
        'reward'          => ['required', 'numeric'],
      ];
      Validator::make($data, $validate)->validate();
    }
    
    {//Coupon Exist
      $exists = Coupon::where('id', $data['couponId'])->exists();
      Validator::make(['exists' => $exists], ['exists' => 'required|accepted'], ['exists.accepted' => 'Купон недоступен!!'])->validate();
    }

    {//Parent Exist
      $exists = User::where('id', $data['parentId'])->exists();
      Validator::make(['exists' => $exists], ['exists' => 'required|accepted'], ['exists.accepted' => 'Аккаунт недоступен!!'])->validate();
    }

    return true;
  }

  

  public function metas(){
    return $this->morphMany('App\Meta', 'metable');
  }

}
