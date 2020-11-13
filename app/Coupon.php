<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\JugeCRUD;
use App\CouponMeta;
use App\Cart;

class Coupon extends Model
{

  public $guarded =[];

  protected $keys = [
    ['key'    => 'code','label' => 'Код'],
    ['key'    => 'discount','label' => 'Скидка'],
    ['key'    => 'expire_date','label' => 'Дата истечения'],
    ['key'    => 'min_summ','label' => 'Минимальная сумма заказа'],
    ['key'    => 'single_for_user','label' => '1 купон для 1 клиента'],
    ['key'    => 'first_order','label' => 'Только первый заказ'],
  ];  
  protected $postInputs = [
    [
      'name' => 'code',
      'caption' => 'Код',
      'type' => 'locked'
    ],
    [
      'name' => 'discount',
      'caption' => 'Cкидка',
      'type' => 'locked',
    ],
    [
      'name' => 'expire_date',
      'caption' => 'Дата истечения',
      'type' => 'date',
    ],
    [
      'name' => 'min_summ',
      'caption' => 'Минимальная сумма заказа',
      'type' => 'text',
    ],
    [
      'name' => 'single_for_user',
      'caption' => '1 купон для 1 клиента',
      'type' => 'checkbox',
    ],
    [
      'name' => 'first_order',
      'caption' => 'Только первый заказ',
      'type' => 'checkbox',
    ],

  ];
  protected $inputs = [
    [
      'name' => 'code',
      'caption' => 'Код',
    ],
    [
      'name' => 'discount',
      'caption' => 'Cкидка',
      'type' => 'number',
    ],
    [
      'name' => 'expire_date',
      'caption' => 'Дата истечения',
      'type' => 'date',
    ],
    [
      'name' => 'min_summ',
      'caption' => 'Минимальная сумма заказа',
      'type' => 'text',
    ],
    [
      'name' => 'single_for_user',
      'caption' => '1 купон для 1 клиента',
      'type' => 'checkbox',
    ],
    [
      'name' => 'first_order',
      'caption' => 'Только первый заказ',
      'type' => 'checkbox',
    ],
  ];

  public static function validateAttach($coupon,$cart,$request = false){


    {//Coupon
      {//Name
        $couponName = "";
        if($coupon == false){
          //Get name from request
          if(isset($request['coupon'])){
            $couponName = $request['coupon'];
          } 
        }      
      }

      {//Coupon
        if($coupon == false && $couponName != ""){
          $coupon = Coupon::jugeGet(['code'=> $couponName]);
        }
      }

      if(!$coupon){
        $coupon = [];
      }else{
        $coupon = $coupon->toArray();
      }

      if(isset($coupon['min_summ'])){
        $coupon['min_summ'] = intval($coupon['min_summ']);
      }else{
        $coupon['min_summ'] = 0;
      }
        
    }
    
    //Cart      
    $cart = Cart::getCart();
        
    {//Validate
      $validate = [
        'code'                => ['required','exists:coupons,code'],
        'expire_date'         => ['after:today'],
        'min_summ'            => ['numeric','max:' . $cart['pre_price']],
        'single_for_user'     => ['single_for_user'],
        'first_order'         => ['first_order'],
      ];        
      $messages = [
        'code.required'                         => 'Промокод не найден 🙈',
        'code.exists'                           => 'Промокод не найден 🙈',
        'expire_date.after'                     => 'Ууупс... срок действия этого промо кода истек 😞',
        'min_summ.max'                          => "Вы можете применить этот промокод только к покупкам от суммы ".$coupon['min_summ']."p",
        'single_for_user.single_for_user'       => "Ууупс... кажется, вы уже применяли промокод ".$coupon['code'].", а его можно применить только один раз 😞",
        'first_order.first_order'               => "Ууупс... этот промокод можно применить только на первый заказ😞",
      ];
      $cartCoupon = ['cart' => $cart,'coupon' => $coupon];
      Validator::extend('single_for_user', function($k,$v) use ($cartCoupon){
        $attr=$cartCoupon;

        //nope
        if($v == 0) return true;

        //Guest
        if(!($attr['cart']['user_id'] > 0)) return true;
        
        {//Get orders with coupon
          $couponId = $attr['coupon']['id'];
          $order = !(
            Order::where('customer_id', $attr['cart']['user_id'])
              ->whereHas('coupons', function($q)use($couponId){
                $q->where('coupon_id',$couponId);
              })
              ->exists()
          );
        }

        return $order;
      });
      Validator::extend('first_order', function($k,$v) use ($cartCoupon){
        $attr=$cartCoupon;

        //nope
        if($v == 0) return true;

        //Guest
        if(!($attr['cart']['user_id'] > 0)) return true;
        
        {//Get order
          $couponId = $attr['coupon']['id'];
          $order = !(
            Order::where('customer_id', $attr['cart']['user_id'])->exists()
          );
        }

        return $order;
      });
      Validator::make($coupon, $validate, $messages)->validate();
    }

    return true;

  }
  
  //JugeCRUD  
  public function jugeGetInputs()       {return $this->inputs;}
  public function jugeGetPostInputs()   {return $this->postInputs;}
  public function jugeGetKeys()         {return $this->keys;} 
  public static function jugeGet($request) {

    $query = new Coupon;

    //With
    {
      $query = $query->with('metas');
    }

    {//Where
      //Archive
      if(!isset($request['with_archive'])){
        $query = $query->where('archive',0);
      }    
      //Id
      if(isset($request['id'])){
        $query = $query->where('id',$request['id']);
      }     
      //Id
      if(isset($request['code'])){
        $query = $query->where('code',$request['code']);
      }      
    }

    //Sort
    $query = $query->orderBy('created_at',"DESC");    

    //Get
    $coupons = JugeCRUD::get($query,$request);

    //Set metas
    $coupons = JugeCRUD::setMetas($coupons);

    //Single
    if(isset($request['id']) || isset($request['code'])){$coupons = $coupons[0];}
    
    //Return
    return $coupons;
  }
  public static function jugePut($request){
    
    {//Validate
      Validator::make($request, 
        [
          'code'            => ['required','min:2','max:50','unique:coupons,code'],
          'discount'        => ['required','numeric'],
          'expire_date'     => ['date'],
          'first_order'     => ['boolean'],
          'min_summ'        => ['numeric'],
          'single_for_user' => ['boolean'],
        ]  
      )->validate();
    }
    
    {//Save
      try {
        DB::beginTransaction();

        {//Coupon
          $coupon = new Coupon;
          $coupon->code       = $request['code'];
          $coupon->discount   = $request['discount'];
          $coupon->archive    = 0;
          $coupon->save();
        }
        
        {//Meta
          {//Get metas 
            $metas = [];
            foreach ($request as $k => $v) {
              switch ($k) {
                case 'expire_date':
                case 'first_order':
                case 'min_summ':
                case 'single_for_user':
                  $metas[$k] = $v;
                  break;              
                default:break;
              }
            }
          }
          
          {// Insert Metas
            foreach ($metas as $k => $v) {
              DB::table('coupon_metas')->insert([
                'coupon_id' => $coupon->id,
                'name' => $k,
                'value' => $v,
              ]);   
            }
          }
        }
    
        DB::commit();    
      } catch (Exception $e) {          
        // Rollback from DB
        DB::rollback();
        return response(['code' => 'co1','text' => 'coupon put error'], 512)->header('Content-Type', 'text/plain');
      }
    }

    return response()->json(1);
  
  }
  public static function jugePost($request){
    
    {//Validate
      Validator::make($request, 
        [
          'id'              => ['required','exists:coupons'],
          'expire_date'     => ['date'],
          'first_order'     => ['boolean'],
          'min_summ'        => ['numeric'],
          'single_for_user' => ['boolean'],
        ]  
      )->validate();
    }
    
    {//Edit
      try {
        DB::beginTransaction();

        {//Data / Metas
          $data = [];
          $metas = [];
          foreach ($request as $k => $v) {
            switch ($k) {
              //Coupon
              case 'code':
              case 'discount':
                $data[$k] = $v;
                break;     
              //Metas
              case 'expire_date':
              case 'first_order':
              case 'min_summ':
              case 'single_for_user':
                $metas[$k] = $v;
                break;              
              default:break;
            }
          }
        }

        {//Coupon
          if(count($data) > 0)
            $coupon = Coupon::where('id',$request->id)->update($data);
        }
        
        {//Metas
          foreach ($metas as $k => $v) {
            $metas = CouponMeta::updateOrInsert(['coupon_id' => $request['id'], 'name' => $k],['value' => $v]);
          }          
        }
    
        DB::commit();    
      } catch (Exception $e) {          
        // Rollback from DB
        DB::rollback();
        return response(['code' => 'co1','text' => 'coupon put error'], 512)->header('Content-Type', 'text/plain');
      }
    }

    //Get
    $coupon = Coupon::jugeGet(['id' => $request['id']]);
    
    return $coupon;
  
  }
  public static function jugeDelete($request){
     {//Validate
      Validator::make($request, 
        [
          'id'              => ['required','exists:coupons'],
        ]  
      )->validate();
    }
    
    {//Edit
      try {
        DB::beginTransaction();

        {//Coupon
          if(count($data) > 0)
            $coupon = Coupon::where('id',$request->id)->delete($data);
        }
        
        {//Metas
          foreach ($metas as $k => $v) {
            $metas = CouponMeta::where('coupon_id',$request->id)->delete($data);
          }          
        }
    
        DB::commit();    
      } catch (Exception $e) {          
        // Rollback from DB
        DB::rollback();
        return response(['code' => 'co2','text' => 'coupon put error'], 512)->header('Content-Type', 'text/plain');
      }
    }

    //Get    
    return true;   
  }

  //Relations
  public function metas(){
    return $this->hasMany('App\CouponMeta');
  }   
  public function orders(){
    return $this->belongsToMany('App\Order')->withTimestamps(); 
  }  
}
