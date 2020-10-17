<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
  protected $guarded = [];



  public function commentator(){
    return $this->belongsTo('App\User', 'commentator_id');
  }
}
