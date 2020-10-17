<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotFound extends Model
{

  protected $keys = [
    ['key'    => 'user_id','label' => 'user','type' => 'link', 'link' => '/admin/user/{user_id}'],
    ['key'    => 'comment','label' => 'comment'], 
    ['key'    => 'created_at', 'label' => 'Created At'],
  ];

  public function jugeGetKeys()     {return $this->keys;}  
  public function jugeGet($request) {return NotFound::orderBy('created_at','DESC')->get();}
}
