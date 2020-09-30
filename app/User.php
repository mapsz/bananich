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
  
  public function jugeGetKeys()   {return $this->keys;}
  public function jugeGetInputs()   {return $this->inputs;}
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

    //Images
    foreach ($users as $user) {
      $user->images = self::getImages($user->id);          
    }
    //Main_Images
    foreach ($users as $user) {
      $user->mainImage = self::getMainImage($user->id);    
    } 

    //To single id
    if(isset($request['id']) && $request['id'] > 0){
      $users = $users[0];
    }    

    return $users;
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
