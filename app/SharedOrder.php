<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\JugeCRUD;
use App\Address;
use Carbon\Carbon;

class SharedOrder extends Model
{

  public $guarded = [];

  public static function open($data){

    {//Data
      $user = Auth::user();
      $link = SharedOrder::generateLink();
    }

    if(!$user) return false;

    try{
      DB::beginTransaction();{

        {//Put
          $sOrder = new SharedOrder;
          $sOrder->owner_id = $user->id;
          $sOrder->member_count = $data['memberCount'];
          $sOrder->link = $link;
          $sOrder->delivery_date      = $data['date'];
          $sOrder->delivery_time_from = $data['time']['from'];
          $sOrder->delivery_time_to   = $data['time']['to'];
          $sOrder->save();            
        }
        
        {//Attach Address
          $address = [
            'street' => $data['address']['addressStreet'],
            'number' => isset($data['address']['addressNumber']) ? $data['address']['addressNumber'] : null,
            'appart' => isset($data['address']['addressApart']) ? $data['address']['addressApart'] : null,
            'porch' => isset($data['address']['addressPorch']) ? $data['address']['addressPorch'] : null,
            'stage' => isset($data['address']['addressStage']) ? $data['address']['addressStage'] : null,
          ];
          $sOrder->address()->save(new Address($address));
        }
                
        {//Attach Comment
          if(isset($data['comment']) && $data['comment']){
            $sOrder->comment()->save(new Comment(['body' => $data['comment']]));
          }          
        }

        //Attach status
        SharedOrder::changeStatus($sOrder,100,$user->id);

        //Attach owner    
        $sOrder->users()->attach($user->id);

      }DB::commit();    
    } catch (Exception $e){
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'so1','text' => 'error open shared order'], 512)->header('Content-Type', 'text/plain');
    }
    
    return $sOrder;
  }

  public static function join($link,$userId){
    return SharedOrder::where('link',$link)->first()->users()->attach($userId);
  }

  public static function changeStatus($sOrder, $statusId, $userId = false){
    
    {// Shared order post
      $sOrder->status_id = $statusId;
      $sOrder->save();
    }

    {//Attach status      
      {//Set user
        if($userId == false){
          $user = Auth::user();
          if($user){
            $userId = Auth::user()->id;
          }
        }
        $data = [];
        if($userId){
          $data['user_id'] = $userId;
        }
      }
      $sOrder->statuses()->attach(100, $data);
    }



  }

  public static function jugeGet($request = []) {
    //Model
    $query = new self;
  
    {//With
      $query = $query->with('users');
      $query = $query->with('status');
      $query = $query->with('address');
      $query = $query->with('comment');
    }
  
    {//Where
      if(isset($request['link'])){
        $query = $query->where('link',$request['link']);
      }
      if(isset($request['id'])){
        $query = $query->where('id',$request['id']);
      }
    }
  
    //Get
    $data = JugeCRUD::get($query,$request);

    // dd($data);
  
    //Single
    if(isset($request['id'])){$data = $data[0];}
  
    //Return
    return $data;
  }

  private static function generateLink(){

    //TODO@@@ check exist
    return (new \PragmaRX\Random\Random())->size(9)->get();
  }

  
  //Relations
  public function users(){
    return $this->belongsToMany('App\User','shared_order_user','shared_order_id','user_id');
  }  
  public function status(){
    return $this->belongsTo('App\SharedOrderStatus');
  }
  public function statuses(){
    return $this->belongsToMany('App\SharedOrderStatus');
  }
  public function address(){
    return $this->morphOne('App\Address', 'addressable');
  }
  public function comment(){
    return $this->morphOne('App\Comment', 'commentable');
  }


  
  
  
}
