<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use App\InterviewSend;
use App\Sms;

class Interview extends Model
{

    public static function sendInterview($userId, $interviewId){

      //Already send
      if (InterviewSend::where('user_id',$userId)->where('interview_id',$interviewId)->exists()) return false;

      //Get user
      $user = User::where('id',$userId)->first();
      if(!isset($user->phone)) return false;

      try {
        DB::beginTransaction();

        //Put interview
        $interviewSend = new InterviewSend;
        $interviewSend->user_id         = $userId;
        $interviewSend->interview_id    = $interviewId;
        $interviewSend->save();

        //put sms
        $sms = [
            'to'        => $user->phone,
            'body'      => 
                $user->name .
                ', здравствуйте! Это Дарья из Бананыча. Вы недавно делали у нас заказ, и нам бы очень сильно помогло улучшить качество нашего сервиса, если бы вы дали нам честную обратную связь без прикрас. Если у вас найдется буквально пара минут на мини опросик по доставке, будет очень здорово! А мы вам за это подарим приятный промокод к новому заказу) В любом случае спасибо, стали нашим клиентом и отличного вам дня! А вот и ссылка на '.
                'опрос:https://bananich.ru/opros/' . $userId,
            'priority'  => 5,
            'mailing'   => 1,
        ];
        Sms::putSmsSend($sms);

        DB::commit();
      } catch (Exception $e) {          
        // Rollback from DB
        DB::rollback();
        return false;
      }


      return true;

    }

    public static function jugeGet() {
      return Interview::get();
    }
}