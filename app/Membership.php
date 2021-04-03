<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Meta;

class Membership extends Model
{
  public $timestamps = false;
  public $guarded = [];

  public static function add($membershipId, $userId, $orderId = false){

    //Get membership
    $membership = self::find($membershipId);
    if(!$membership) return false;

    //Get user
    $user = User::find($userId);
    if(!$user) return false;

    //Attach 
    $user->memberships()->attach($membershipId, ["user_id" => $userId, 'expire' => now()->add('days', $membership->term)]);

    //Order meta
    if($orderId){
      //Get pivot ID
      $pivotId = DB::table('user_membership')->where('user_id', $userId)->where('membership_id',$membershipId)->orderBy('id','DESC')->first()->id;

      //Add order meta
      DB::table('metas')->insert([
        'metable_id'    => $pivotId,
        'metable_type'  => 'user_membership',
        'name'          => 'order_id',
        'value'         => $orderId,
      ]);
    }

    return true;

  }

  public static function removeByOrder($orderId){

    //Get meta
    $meta = Meta::where('metable_type','user_membership')->where('name','order_id')->where('value',$orderId)->first();

    if(!$meta) return;

    //Detach
    DB::table('user_membership')->where('id', $meta->metable_id)->delete();

    //Delete meta
    $meta->delete();

    return;
  }
}
