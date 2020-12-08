<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
  protected $guarded = [];
  public function contactable(){
    return $this->morphTo();
  }
}
