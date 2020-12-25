<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JugeLogs extends Model
{
  public $guarded = [];

  public static function log($code, $body = ""){

    $log = new JugeLogs;
    $log->code = $code;
    $log->body = $body;
    return $log->save();
  }
}
