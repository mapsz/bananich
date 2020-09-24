<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

  public $timestamps = false;
  
  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/category/{id}'],
    ['key'    => 'name','label' => 'Название','type' => 'link', 'link' => '/admin/category/{id}'],
    ['key'    => 'sort','label' => 'Сортировка']
  ];
  protected $inputs = [
    [
      'name' => 'name',
      'caption' => 'Название',
      'required' => true,
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
  public function jugeGet($request) {
      
    $query = new Category;


    //With
    do{
      //Products
      $query = $query->with('products');
      //Categories
      $query = $query->with('categories');
    }while(0);

    //Where
    do{
      if(isset($request['id'])){
        $query = $query->where('id', $request['id']);
      }
    }while(0);

    $query = $query->orderBy('sort','desc');

    //Get
    $categories = $query->get();

    //Image
    foreach ($categories as $key => $cat) {
      $cat['images']       = self::getImages($cat->id);
      $cat['mainImage']    = self::getMainImage($cat->id);
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
