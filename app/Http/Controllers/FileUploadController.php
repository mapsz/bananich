<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;

class FileUploadController extends Controller
{
  public function fileUpload(Request $request){

    $file = $request->file('file');

    //Catch file
    $fileUpload = new FileUpload;
    $fileEnc = $fileUpload->cacheFile($file);

    //Response
    if(!$fileEnc)
      //Error
      return response('Could not save file', 501)
                ->header('Content-Type', 'text/plain');
    else{
      //Success
      return response($fileEnc, 200)
                ->header('Content-Type', 'text/plain');
    }
  }  
}
