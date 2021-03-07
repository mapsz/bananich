<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\BananichResetPasswordNotification;
use App\Parse;
use App\JugeCRUD;
use App\Bonus;


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

  public static function addAddress($data, $userId){

    //Get user
    $user = User::find($userId);

    {//Attach Address
      $address = [
        'street' => $data['street'],
        'number' => isset($data['number']) ? $data['number'] : null,
        'appart' => isset($data['appart']) ? $data['appart'] : null,
        'porch' => isset($data['porch']) ? $data['porch'] : null,
        'stage' => isset($data['stage']) ? $data['stage'] : null,
        'intercom' => isset($data['intercom']) ? $data['intercom'] : null,
        'default' => (isset($data['default']) && $data['default']) ? 1 : 0,
      ];
      $user->addresses()->save(new Address($address));
    }

    // Set dufault
    if($data['default']){
      $address = Address::where('addressable_type', "App\User")->where('addressable_id', $userId)->orderBy('id', 'desc')->first();
      User::setDefaultAddress($address->id);
    }

    return true;
  }

  public static function postAddress($data){

    $address = Address::find($data['id']);

    $update = [];

    if(isset($data['street']) && $data['street']) $update['street'] = $data['street'];
    if(isset($data['number']) && $data['number']) $update['number'] = $data['number'];
    if(isset($data['appart']) && $data['appart']) $update['appart'] = $data['appart'];
    if(isset($data['porch']) && $data['porch']) $update['porch'] = $data['porch'];
    if(isset($data['stage']) && $data['stage']) $update['stage'] = $data['stage'];
    if(isset($data['intercom']) && $data['intercom']) $update['intercom'] = $data['intercom'];
    if(isset($data['default']) && $data['default']) $update['default'] = $data['default'] ? 1 : 0;
    if(isset($data['x']) && $data['x']) $update['x'] = $update['x'] = $data['x'];
    if(isset($data['y']) && $data['y']) $update['y'] = $update['y'] = $data['y'];
       
    $address->update($update);

    return true;
  }
  
  public static function setDefaultAddress($id){
    {//Get addresses
      //Single
      $address = Address::find($id);
      //User addresses
      $addresses = Address::where('addressable_type', "App\User")->where('addressable_id', $address->addressable_id)->get();
    }

    $address->default = 1;
    $address->save();

    //Remove defaults
    foreach ($addresses as $k => $a) {
      if($a->id != $id){
        $a->default = 0;
        $a->save();
      }
    }
    
    return true;
  }

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

  public static function toСollector($id){
    $role = Role::where(['name' => 'collector'])->first();
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
      // $query = $query->with('addresses.coords');
    }

    //Where
    if("WHERE" == "WHERE"){

      //Id
      if(isset($request['id']) && $request['id'] > 0){
        $query = $query->where('id', $request['id']);
      }      
      
      //Ids
      if(isset($request['ids']) && is_array($request['ids']) && count($request['ids']) > 0){
        $query = $query->whereIn('id',$request['ids']);
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
  // public function addresses(){
  //   return $this->hasMany('App\UserAddress');
  // }
  public function addresses(){
    return $this->morphMany('App\Address', 'addressable');
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

{
  // SELECT u.`id`,`email`,`phone`, `name`,b.`left`,delivery_date,`comment`,oc.`count`,address FROM users u
  // /* Order Count*/
  // LEFT JOIN (
  // 	SELECT id, customer_id, COUNT(id) AS `count` FROM (
  // 		SELECT o.id,`customer_id`, order_status_id FROM orders o 
  // 		INNER JOIN order_order_status s
  // 		ON o.id = s.order_id
  // 		WHERE order_status_id = 1
  // 		AND customer_id <> 0
  // 	) os
  // 	GROUP BY `customer_id`
  // 	) oc
  // ON u.id = oc.customer_id
  // /* Comment */
  // LEFT JOIN (
  // 	SELECT * FROM (
  // 		SELECT user_id, `comment` FROM user_comments
  // 		ORDER BY id desc
  // 	)cl
  // 	GROUP BY `user_id`
  // ) c
  // ON u.id = c.user_id	
  // /* Bonus */
  // LEFT JOIN (
  // 	SELECT user_id, MAX(`id`), `left` FROM (
  // 		SELECT * FROM bonuses
  // 		ORDER BY id desc
  // 	)bl	
  // 	GROUP BY `user_id`	
  // ) b
  // ON u.id = b.user_id
  // /* Last Order */
  // LEFT JOIN (
  // 	SELECT id, customer_id, delivery_date,address FROM (
  // 		SELECT ol.id, customer_id, delivery_date, address FROM orders ol
  // 		INNER JOIN (
  // 			SELECT * FROM order_order_status
  // 			WHERE order_status_id = 1
  // 		)os
  // 		ON ol.id = os.order_id
  // 		ORDER BY ol.id desc
  // 	) oz
  // 	Group by customer_id
  // ) o
  // ON u.id = o.customer_id

  // WHERE `count` > 0
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



// SELECT 
// 	u.id,
// 	gg.`c`AS `orders`,
//  	u.email,
//   	u.`name`,
// 	u.`phone`
//  FROM (
// 	SELECT COUNT('customer_id') AS `c`, customer_id FROM (
// 	SELECT * FROM (
// 		select t.order_id, t.order_status_id, r.MaxDate 
// 		FROM 
// 		( 
// 		SELECT order_id, MAX(created_at) as MaxDate 
// 		FROM order_order_status 
// 		GROUP BY order_id 
// 		) r 
// 		INNER JOIN order_order_status t 
// 		ON t.order_id = r.order_id 
// 		AND t.created_at = r.MaxDate 
// 	) `status`
// 	INNER JOIN `orders` o
// 	ON o.id = `status`.order_id
// 	WHERE order_status_id = 1
// ) o
// 	WHERE delivery_date > '2020-09-10'
// 	GROUP BY customer_id
// ) AS gg
// INNER JOIN users u
// ON gg.customer_id = u.id
// WHERE c > 1
// AND c < 999