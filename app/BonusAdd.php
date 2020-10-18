<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusAdd extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'bonus_id';


      //Relations
  public function bonus(){
    return $this->belongsTo('App\Bonus');
  }
}
