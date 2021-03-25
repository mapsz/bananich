<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    public $timestamps=false;
    public $guarded=[];

    
  public function jugeGet($request) {
    return Site::with('pages')->get();
  }    

  public function pages()
  {
    return $this->belongsToMany('App\Page','sites_pages');
  }
}
