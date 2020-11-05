<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Email extends Model
{

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/email/{id}'],
    ['key'    => 'name','label' => 'название'],
    ['key'    => 'created_at','label' => 'дата'],
  ];


  public static function customTags($html,$user = false){

    // Products
    if('producs'){
      //Find products
      $matches = [];
      $pattern = '/&lt;:product_[0-9]+:&gt;/';
      preg_match_all($pattern, $html, $matches,PREG_OFFSET_CAPTURE);
      $matches = $matches[0];

      //Get ids
      $productsIds = [];      
      foreach ($matches as $key => $match) {
        $productMatch = 0;
        preg_match('/[0-9]+/',$match[0],$productMatch);        
        array_push($productsIds,$productMatch[0]);
      }

      //Get products
      $producsts = Product::jugeGet(['ids' => $productsIds, 'get_all' => 1]);

      //Insert products
      foreach ($producsts as $k => $product) {

        // dd($product);
        $productHtml_start = "".
          "<div style='width:160px;display: inline-block;margin:15px 7px'>".
            "<div><img width='160' height='160' src='https://bananich.ru/{$product->mainImage}' alt=''></div>".            
        "";

        $productHtml_2 = "".
            "<div style='font-size: medium; line-height: 1.2; height: 55px;'><b>{$product->name}</b></div>".
            "<div style='font-size: medium;'>{$product->unit_view}</div>".
        "";

        $productHtml_3 = "".
            (
              ($product->price != $product->final_price) ? 
              "<span style='font-size: medium;text-decoration: line-through;'>{$product->price}</span>" : "" 
            ) .
            "<span style='font-size: medium;color: rgb(255, 92, 0);'><b> {$product->final_price}</b></span>".
        "";

        $productHtml_4 = "".
          "<div align='center'>
            <a href='https://bananich.ru/product/{$product->id}' style='text-decoration: none;'>
              <p align='center' style='
                width: 120px;
                margin: auto;
                margin-top: 20px;
                background-color: #fbe214;
                padding: 15px;
                border-radius: 30px;
                color:black;
              '>
                Купить
              </p>                
            </a>
          </div>".
        "";

        $productHtml_end = "".
          "</div>".
        "";     
        
        $productHtml = $productHtml_start.$productHtml_2.$productHtml_3.$productHtml_4.$productHtml_end;

        $html = str_replace($matches[$k][0],$productHtml,$html);

      }

    }


    // Categories
    if('categories'){
      //Find products
      $matches = [];
      $pattern = '/&lt;:category_[0-9]+:&gt;/';
      preg_match_all($pattern, $html, $matches,PREG_OFFSET_CAPTURE);
      $matches = $matches[0];

      //Get ids
      $categoryIds = [];      
      foreach ($matches as $key => $match) {
        $categoryMatch = 0;
        preg_match('/[0-9]+/',$match[0],$categoryMatch);        
        array_push($categoryIds,$categoryMatch[0]);
      }

      //Get products
      $categories = Category::jugeGet(['ids' => $categoryIds]);

      //Insert products
      foreach ($categories as $k => $category) {

        // dd($product);
        $productHtml_start = "".
          "<div style='width:160px;display: inline-block;margin:15px 7px'>".
            "<div><img width='160' height='160' src='https://bananich.ru/{$category->mainImage}' alt=''></div>".            
        "";

        $productHtml_2 = "".
            "<div align='center' style='
              display:flex; 
              justify-content:center; 
              align-items:center; 
              padding-top:10px; 
              font-size: medium; 
              line-height: 1.2; 
              height: 55px;
            '><b>{$category->name}</b></div>".
        "";

        $productHtml_3 = "";

        $productHtml_4 = "".
          "<div align='center'>
            <a href='https://bananich.ru/category/{$category->id}' style='text-decoration: none;'>
              <p align='center' style='
                width: 120px;
                margin: auto;
                margin-top: 20px;
                background-color: #fbe214;
                padding: 15px;
                border-radius: 30px;
                color:black;
              '>
                Заказать
              </p>                
            </a>
          </div>".
        "";

        $productHtml_end = "".
          "</div>".
        "";     
        
        $productHtml = $productHtml_start.$productHtml_2.$productHtml_3.$productHtml_4.$productHtml_end;

        $html = str_replace($matches[$k][0],$productHtml,$html);

      }

    }


    //Name
    if('name'){
      if($user){
        $name = is_array($user) ? $user['name'] : $user->name;
        //Replace names
        $html = str_replace('&lt;:name:&gt;',$name,$html);
      }
    }


    return $html;

  }

  
  //JugeCRUD  
  public function jugeGetKeys()     {return $this->keys;}  
  public static function jugeGet($request) {

    
    $query = new Email;
          
    //Id
    if(isset($request['id']) && $request['id']){
      
      $query = $query->where('id', '=', $request['id']);
    }

    $emails = $query->get();

    foreach ($emails as $key => $email) {
      //Html
      if('html'){
        $design = json_decode($email->design);

        //Get rows
        $html = '';
        for ($i=1; $i < count($design->body->rows)-1; $i++) {           
          for ($j=0; $j < count($design->body->rows[$i]->columns); $j++) { 
            for ($k=0; $k < count($design->body->rows[$i]->columns[$j]->contents); $k++) {
              //Row           
              $row = $design->body->rows[$i]->columns[$j]->contents[$k];

              //Get style
              if('style'){
                $style = "style='".(
                  "margin:".$row->values->containerPadding.
                  "'"
                );
              }

              //Types
              if('types'){
                $add = "";
                if($row->type == "text"){                
                  $add = "<div $style>" . $row->values->text . '</div>';
                };
                if($row->type == "divider"){ 
                  $add = "<hr $style>";
                };
              }

              //Add
              $html .= $add;
            }
          }
        }
        
        $email['html'] = $html;
      }
    }


    //Single order by id
    if(isset($request['id']) && $request['id']){
      $emails = $emails[0];      
    }    

    
    return $emails;

  }
}
