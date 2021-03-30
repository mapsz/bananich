<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Membership extends Model
{
  public $timestamps = false;
  public $guarded = [];

  public static function add($membershipId, $userId){

    $membership = self::find($membershipId);

    if(!$membership) return false;

    DB::table("user_membership")->insert(
      [
        "membership_id" => $membershipId, 
        "user_id" => $userId,
        "expire" => now()->add('days', $membership->term)
      ]
    );

    return true;

  }
}
