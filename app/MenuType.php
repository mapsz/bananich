<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuType extends Model
{
    public $timestamps = false;


    public function menus()
    {
        return $this->belongsToMany('App\Menu');
    }
}
