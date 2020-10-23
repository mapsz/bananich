<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/email/{id}'],
    ['key'    => 'name','label' => 'название'],
    ['key'    => 'created_at','label' => 'дата'],
  ];


  
  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public function jugeGet($request) {
    
    $query = new Email;
          
    //Id
    if(isset($request['id']) && $request['id']){
      $query = $query->where('id', '=', $request['id']);
    }

    $emails = $query->get();

    //Single order by id
    if(isset($request['id']) && $request['id']){
      $emails = $emails[0];      
    }    

    
    return $emails;

  }
}
