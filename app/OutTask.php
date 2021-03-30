<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutTask extends Model
{
  public static function put($name, $priority = 0){

    //Check exists
    if(self::where('name',$name)->where('status',0)->exists()) return true;
    if(self::where('name',$name)->where('status',2)->exists()) return true;
    
    {//Put
      $task = new OutTask;
      $task->name = $name;
      $task->priority = $priority;
      $task->priority = $priority;
      $task->status = 0;
    }

    return $task->save();

  }
}
