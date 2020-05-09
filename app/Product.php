<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ArchiveProduct;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Product extends Model
{

  public function archiveUpdate(){

    //Check changes
    $original = $this->getOriginal();
    if($original == $this->getAttributes()){
      return true;
    }
    
    try {
      DB::beginTransaction();

      //Save archive
      //Get original
      $archiveFill = $original;
      //Remove bad fields
      unset($archiveFill['id']);
      unset($archiveFill['gruzka_priority']);
      //Set data
      $archive = new ArchiveProduct;    
      $archive->product_id = $original['id'];
      $archive->archive_at = Carbon::now();
      $archive->fill($archiveFill);
      if(!$archive->save())
        throw new Exception("Cant save archive!", 'a1');

      //Save Product
      if(!$this->save())
        throw new Exception("Cant save product!", 'a2');
      

      //Store to DB
      DB::commit();
    }catch(Exception $e){        
      // Rollback from DB
      DB::rollback();
      return false;
    }
  
    return true;

  }

  public static function saveImages($images, $productId){
    foreach ($images as $k => $image) {
      //Set path
      $path = public_path().'\products\images\source\\' . $productId . '_' . $k;
      //Save Image
      if(!FileUpload::saveFile($image,$path)){
        return false;
      }
    }
    return true;
    
  }

  public function items(){
      return $this->hasMany('App\Item');
  }
  public function archive(){
      return $this->hasMany('App\ArchiveProduct');
  }  
  public function discounts(){
      return $this->hasMany('App\Discount');
  } 
  public function goods(){
      return $this->hasMany('App\Goods');
  }   
  public function suppliers(){
    return $this->belongsToMany('App\Supplier')
    ->withPivot('supplier_product_id', 'created_at');
  }
}
