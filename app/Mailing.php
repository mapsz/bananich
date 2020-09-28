<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Mail;
use App\User;

class Mailing extends Model
{
    public static function open(){
      // $users = User::get();

      // foreach ($users as $key => $user) {  
      //   $email = $user->email;
      //   Mail::send('mail.open', ['user' => $user->toarray()], function($m)use($email){
      //     $m->to($email,'to');
      //     $m->from('no-reply@bananich.ru');
      //     $m->subject('Бананыч вернулся! И у нас много новостей)');
      //   });
      //   dump(count($users) - $key . ' - ' . $user->name . ' - ' . $user->email);
        
      // }

    }
}
