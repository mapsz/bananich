<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
  
  

  
  public function coords(){
    return $this->hasMany('App\PolygonCoord');
  }
}
