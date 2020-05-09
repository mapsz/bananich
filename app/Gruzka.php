<?php

namespace App;
use App\Item;

use Illuminate\Database\Eloquent\Model;

class Gruzka extends Model
{
  public static function removeContainers($itemId){
    return Item::find($itemId)->containers()->detach();
  }
}
