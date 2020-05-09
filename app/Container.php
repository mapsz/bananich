<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
  public $timestamps = false;
  public $guarded = [];

  public function items()
  {
    return $this->belongsToMany('App\Items')
              ->withTimestamps()
              ->withPivot('user_id', 'created_at');
  }      
}
