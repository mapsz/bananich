<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Statistic;

class statisticOrder extends Model
{
  public function jugeGetKeys()     {return Statistic::jugeGetKeys()['order'];}  
}
