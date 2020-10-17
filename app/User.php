<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\BananichResetPasswordNotification;
use App\Parse;
use App\JugeCRUD;
use App\bonus;


use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/user/{id}'],
    ['key'    => 'email','label' => 'E-mail'],    
    ['key'    => 'name','label' => 'Имя'],    
    ['key'    => 'surname','label' => 'Фамилия'],    
    ['key'    => 'phone','label' => 'Телефон'],    
  ];  

  protected $inputs = [
    [
      'name' => 'images',
      'caption' => 'Фото',
      'type' => 'file',
      'fileMax' => 1,
    ],
    [
      'name' => 'email',
      'caption' => 'E-mail',
      'required' => true,
    ],
    [
      'name' => 'name',
      'caption' => 'Имя',
      'required' => true,
    ],
    [
      'name' => 'surname',
      'caption' => 'Фамилия',
    ],
    [
      'name' => 'phone',
      'caption' => 'Телефон',
    ]

  ];

  public function isAdmin(){
    $roles = $this->getRoleNames();
    foreach ($roles as $key => $role) {
      if($role == 'admin') return true;
    }
    return false;
  }

  public static function getImages($id){

    $path = public_path() . '/users/images/source';
    $files = scandir($path);

    $rFiles = [];
    foreach ($files as $file) {
      if(strpos($file,$id.'_') === 0){
        array_push($rFiles,'/users/images/source/' .$file);
      }      
    }

    return $rFiles;

  }  

  public static function getMainImage($id){

    $xpath = '/users/images/main';
    $path = public_path() . $xpath;
    $files = scandir($path);
    
    $image = false;
    foreach ($files as $file) {
      if(strpos($file,$id.'.') === 0){
        $image = $xpath .'/'. $file;
        break;
      }
    }

    if(!$image) $image = $xpath .'/no-image.png';

    return $image;

  }

  public static function toDriver($id){
    $role = Role::where(['name' => 'driver'])->first();
    $user = User::find($id);
    $user->assignRole($role);
    return true;
  }
  
  public function jugeGetKeys()   {return $this->keys;}
  public function jugeGetInputs()   {return $this->inputs;}
  public static function jugeGet($request){

    //Make query
    $query = new User;

    //With
    if("WITH" == "WITH"){
      //Comment
      $query = $query->with('comment');
      //Referal
      $query = $query->with('referal');
      //Addresses
      $query = $query->with('addresses');
    }

    //Where
    if("WHERE" == "WHERE"){

      //Id
      if(isset($request['id']) && $request['id'] > 0){
        $query = $query->where('id', $request['id']);
      }

      //Search
      if(isset($request['search']) && $request['search'] != ""){
        $search = $request['search'];
        $query = $query->where(function($q)use($search) {
          $q->where('id', 'LIKE', "%{$search}%")
          ->orWhere('name', 'LIKE', "%{$search}%")
          ->orWhere('phone', 'LIKE', "%{$search}%")
          ->orWhere('email', 'LIKE', "%{$search}%")
          ->orWhere('surname', 'LIKE', "%{$search}%")
          ;
        });
      }


    }

    //Get
    $users = JugeCRUD::get($query,$request);

    //After Query
    if("AfterQuery" == "AfterQuery"){
      //Loop
      foreach ($users as $user) {
        //Images
        $user->images = self::getImages($user->id);    
        //Main_Images
        $user->mainImage = self::getMainImage($user->id);          
        //Get roles
        $user->getRoleNames();
        //Bonus
        if(isset($request['with_bonus'])){
          $user['bonus'] = Bonus::left($user->id);
        }
      }
    }

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


// >2 orders list
// SELECT u.id, u.email, u.`name` FROM (
// 	SELECT COUNT('customer_id') AS `c`, customer_id FROM orders
// 	GROUP BY customer_id
// ) AS gg
// INNER JOIN users u
// ON gg.customer_id = u.id
// WHERE c > 1
// AND c < 999