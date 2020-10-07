<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\SmsSend;

class Sms extends Model
{
  //Keys
  protected $keys = [
    ['key'    => 'to','label' => 'Номер'],
    ['key'    => 'count','label' => 'количество'],
    ['key'    => 'body','label' => 'текст'],
    ['key'    => 'send.priority','label' => 'приоритет'],
    ['key'    => 'send.send','label' => 'отправленно'],
    ['key'    => 'send.delivered','label' => 'доставленно'],
    ['key'    => 'created_at','label' => 'дата'],
  ];


  //Put sms send
  public static function putSmsToSend($data){

    //Save
    try {
      DB::beginTransaction();

      //Put sms
      $sms        = new Sms;
      $sms->to    = $data['to'];
      $sms->body  = $data['body'];
      $sms->save();

      //Put send sms
      $smsSend = new SmsSend;
      $smsSend->sms_id    = $sms->id;
      $smsSend->priority  = isset($data['priority']) ? $data['priority'] : 0;
      $smsSend->mailing   = isset($data['mailing']) ? $data['mailing'] : 0;
      $smsSend->save();

      //Store to DB
      DB::commit();  
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'sms1','text' => 'put send error'], 512)->header('Content-Type', 'text/plain');
    }

    return 1;

  }

  //JugeCRUD
  public function jugeGetKeys()       {return $this->keys;}
  public static function jugeGet(/*$request*/) {
    $sms = new Sms;
    $sms = $sms
                ->join(DB::Raw('(
                      SELECT `to`, COUNT(`to`) as count,MAX(`created_at`) AS created_at
                      FROM `sms`
                      GROUP BY `to`
                    ) lsms
                  '), function($join)
                {
                    $join->on('lsms.to', '=', 'sms.to');
                    $join->on('lsms.created_at','=', 'sms.created_at');
                })
                ->with('send')
                ->orderBy('sms.created_at','DESC')
                ->get();


    return $sms;
  }

  //Send
  public function send(){
    return $this->hasOne('App\SmsSend','sms_id');
  }    
  //Report
  public function report(){
    return $this->hasOne('App\SmsReport','sms_id');
  }  

}
