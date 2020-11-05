<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

  public $timestamps = false;
  
  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/category/{id}'],
    ['key'    => 'name','label' => 'Название','type' => 'link', 'link' => '/admin/category/{id}'],
    ['key'    => 'sort','label' => 'Сортировка'],
    ['key'    => 'main_menu','label' => 'главное меню']
  ];
  protected $inputs = [
    [
      'name' => 'name',
      'caption' => 'Название',
      'required' => true,
    ],
    [
      'name' => 'main_menu',
      'caption' => 'главное меню',
      'type' => 'checkbox',
    ],
    [
      'name' => 'sort',
      'caption' => 'сортировка',
    ],
    [
      'name' => 'images',
      'caption' => 'Фото',
      'type' => 'file',
      'fileMax' => 8,
    ],
  ];

  public static function getImages($id){

    $short_path = '/categories/images';
    $path = public_path() . $short_path;    
    $files = scandir($path);

    $rFiles = [];
    foreach ($files as $file) {
      if(strpos($file,strval($id) . '_source') === 0){
        array_push($rFiles, $short_path.'/'.$file);
      }      
    }

    return $rFiles;

  }

  public static function getMainImage($id){

    $short_path = '/categories/images';
    $path = public_path() . $short_path;   
    $files = scandir($path);

    $rFiles = [];
    foreach ($files as $file) {
      if(strpos($file,strval($id) . '.') === 0){
        return $short_path.'/'.$file;
      }      
    }  

    return '/image/r-1.png';

  }


  //JugeCRUD  
  public function jugeGetInputs()   {return $this->inputs;}    
  public function jugeGetKeys()     {return $this->keys;} 
  public static function jugeGet($request) {
      
    $query = new Category;


    //With
    if("WITH" == "WITH"){
      //Products
      if(!isset($request['no_products'])){
        $query = $query->with('products');
      }
      //Categories
      $query = $query->with('categories');
    }

    //Where
    do{
      if(isset($request['ids']) && is_array($request['ids'])){
        $query = $query->whereIn('id',$request['ids']);
      }
      if(isset($request['id'])){
        $query = $query->where('id', $request['id']);
      }
      if(isset($request['menu'])){
        $query = $query->where('main_menu', 1);
      }
    }while(0);

    $query = $query->orderBy('sort','asc');

    //Get
    $categories = $query->get();

    //Image
    foreach ($categories as $key => $cat) {
      $cat['images']       = self::getImages($cat->id);
      $cat['mainImage']    = self::getMainImage($cat->id);
      foreach ($cat->categories as $key => $c) {
        $c['images']       = self::getImages($c->id);
        $c['mainImage']    = self::getMainImage($c->id);
      }
    }

    //Single
    if(isset($request['id'])){
      $categories = $categories[0];
    }



    return $categories;    
  } 


  public function products(){
    return $this->belongsToMany('App\Product','products_categories','categoty_id','product_id');
  }

  public function categories(){
    return $this->belongsToMany('App\Category','category_category','parent_category_id','child_category_id');
  }

}
