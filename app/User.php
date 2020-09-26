<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\BananichResetPasswordNotification;
use App\Parse;

class User extends Authenticatable
{
  use Notifiable;
  use HasRoles;

  protected $guarded = [];
  protected $hidden = [
      'password', 'remember_token',
  ];
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  public static function jugeGet($request){

    //Make query
    $query = new User;

    //Parse if doesnt exist
    if(isset($request['id']) && $request['id'] > 0){
      $exists = $query->where('id', $request['id'])->exists();
      if(!$exists){
        Parse::user($request['id']);
      }
    }

    //With
    do{
      //Comment
      $query = $query->with('comment');
      //Referal
      $query = $query->with('referal');
      //Addresses
      $query = $query->with('addresses');
      //Permissions
      $query = $query->with('permissions');
    }while(0);    

    //Where Single id
    if(isset($request['id']) && $request['id'] > 0){
      $query = $query->where('id', $request['id']);
    }

    //Get
    $users = $query->get();

    //To single id
    if(isset($request['id']) && $request['id'] > 0){
      $users = $users[0];
    }    

    return $users;
  }


  public function comment(){
    return $this->hasOne('App\UserComment');
  }
  public function addresses(){
    return $this->hasMany('App\UserAddress');
  }
  public function referal(){
    return $this->hasOne('App\UserReferal');
  }
  public function orders(){
    return $this->hasMany('App\Order','customer_id');
  }

  public function sendPasswordResetNotification($token)
  {
      // Your your own implementation.
      $this->notify(new BananichResetPasswordNotification($token));
  }

}
