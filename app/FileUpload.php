<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Sopamo\LaravelFilepond\Filepond;
use Illuminate\Support\Facades\File;

class FileUpload extends Model
{
  public static function cacheFile($file){
    $filepond = new Filepond();
    //Get temp path
    $tempPath = config('filepond.temporary_files_path');   
    //Check path exists
    if (!file_exists($tempPath)){
      mkdir($tempPath, 0755, true);
    }    
    //Make unique name
    $filePath = tempnam($tempPath, 'laravel-filepond');
    //Add extension
    $filePath .= '.' . $file->extension();      
    $filePathParts = pathinfo($filePath);
    //Attemp to move
    if (!$file->move($filePathParts['dirname'], $filePathParts['basename'])) {
      return false;
    }
    //Get file encription
    return $filepond->getServerIdFromPath($filePath);
  }
  public static function saveFile($enc,$pathName){
    $filepond = new Filepond();       
    //Get cache file path
    $cacheFilePath = $filepond->getPathFromServerId($enc);
    //Get File ext
    $ext = pathinfo($cacheFilePath)['extension'];
    // jpeg to jpg
    if($ext == 'jpeg') $ext = 'jpg';
    //Check save path exists
    if (!file_exists(pathinfo($pathName)['dirname'])){
      mkdir(pathinfo($pathName)['dirname'], 0755, true);
    }   
    //Full save path
    $fullPath = $pathName . '.' . $ext;
    //Move file
    if(\File::move($cacheFilePath, $fullPath)){
      return true;
    }else
      return false;
  }
  public static function getEncFilePath($enc){
    $filepond = new Filepond();       
    return $filepond->getPathFromServerId($enc);
  }
}
