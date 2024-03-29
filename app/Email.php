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


  public static function customTags($html,$user = false, $type = false){

    $site = $type == 'x' ? 'https://neolavka.ru/' : 'https://bananich.ru/';
    $color = $type == 'x' ? '#8ac2a7' : '#fbe214';
    

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
      foreach ($productsIds as $k => $id) {
        //Get product
        $product = false;
        foreach ($producsts as $k => $p) {
          if($p->id == $id){
            $product = $p;
            break;
          }
        }      

        // dump($id);       


        $productHtml_start = "".
          "<div style='width:160px;display: inline-block;margin:15px 7px'>".
            "<div><img width='160' height='160' src='{$site}{$product->mainImage}' alt=''></div>".            
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

        $productHtml_link = "?utm_source=mail2311&utm_medium=mail2311&utm_campaign=mail2311";

        $productHtml_4 = "".
          "<div align='center'>
            <a href='{$site}product/{$product->id}{$productHtml_link}' style='text-decoration: none;'>
              <p align='center' style='
                width: 120px;
                margin: auto;
                margin-top: 20px;
                background-color: {$color};
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

        // dump('&lt;:product_'.$id.':&gt;');
        // dump($matches[$k][0]);

        $html = str_replace('&lt;:product_'.$id.':&gt;',$productHtml,$html);

        // dd($html);

      }

    }


    // Categories
    if('categories'){
      //Find category
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

      //Get categories
      $categories = Category::jugeGet(['ids' => $categoryIds]);

      //Insert category
      foreach ($categoryIds as $k => $id) {

        //Get category
        $category = false;
        foreach ($categories as $j => $c) {
          if($c->id == $id){
            $category = $c;
            break;
          }
        }


        // dd($product);
        $productHtml_start = "".
          "<div style='width:160px;display: inline-block;margin:15px 7px'>".
            "<div><img width='160' height='160' src='{$site}{$category->mainImage}' alt=''></div>".            
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
            <a href='{$site}category/{$category->id}' style='text-decoration: none;'>
              <p align='center' style='
                width: 120px;
                margin: auto;
                margin-top: 20px;
                background-color: {$color};
                padding: 15px;
                border-radius: 30px;
                color:black;
              '>
                В раздел
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
                $containerStyle = "style='".(
                  ((isset($row->values->containerPadding) && $row->type != "divider") ? ("padding:".$row->values->containerPadding.";") : ('')) .
                  (isset($row->values->textAlign) ? ("text-align:".$row->values->textAlign.";") : ('')) .
                  (isset($row->values->lineHeight) ? ("line-height:".$row->values->lineHeight.";") : ('')) .
                  (isset($row->values->color) ? ("color:".$row->values->color.";") : ('')) .                                                    
                  "'"
                );
                $elementStyle = "style='".(
                  ($row->type == "button" ? ("text-decoration: none;") : ('') ) .
                  (isset($row->values->padding) ? ("padding:".$row->values->padding.";") : ('')) .
                  (isset($row->values->borderRadius) ? ("border-radius:".$row->values->borderRadius.";") : ('')) .
                  (isset($row->values->calculatedWidth) ? ("width:".$row->values->calculatedWidth."px;") : ('')) .
                  (isset($row->values->calculatedHeight) ? ("height:".$row->values->calculatedHeight."px;") : ('')) .
                  ( (isset($row->values->buttonColors) && isset($row->values->buttonColors->color)) ? ("color:".$row->values->buttonColors->color.";") : ('') ) .
                  ( (isset($row->values->buttonColors) && isset($row->values->buttonColors->backgroundColor)) ? ("background-color:".$row->values->buttonColors->backgroundColor.";") : ('') ) .            
                  "'"
                );

              }


              //Types
              if('types'){
                $add = "";
                if($row->type == "text"){                
                  $add = "<div $containerStyle>" . $row->values->text . '</div>';
                };
                if($row->type == "divider"){ 
                  $add = "<hr $containerStyle>";
                };
                if($row->type == "button"){ 
                  $add = "<div $containerStyle ><a $elementStyle href='{$row->values->href->values->href}'>" . $row->values->text . '</a></div>';
                }
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
