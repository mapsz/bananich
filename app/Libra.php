<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Products;

class Libra extends Model
{

  /*
    // "Инжир"
    // "Кофе Ваниль"
    // "Кунжут черный"
    // "Кунжут"
    // "Курага"
    // "Лен"
    // "Маш"
    // "Премиум смесь"Иммунитет 7 суперфудов""
    // "Рис Басмати"
    // "Семена тыквы н/о"
    // "Тыква Премиум, с высоким содержанием белка"
    // "Финики королевские"
    // "Чечевица"
    //   "Кардамон молотый"
    // "Морковь сушеная"
    // "Мускатный орех молотый"
    // "Мята сушеная"
    // "Перец душистый горошек"
    // "Перец черный горошек"
    // "Петрушка сушеная"
    // "Томаты сушеные"
    // "Хмели-сунели"
    // "Ванилин"
    // "Желатин"
    // "Лимонная кислота"
    // "Чеснок гранулированный"
  */

  //Proporties
  protected $guarded = [];
  protected $keys = [
    ['key'    => 'id','label' => '#'],  
    ['key'    => 'button','label' => 'Кнопка'],      
    ['key'    => 'product_id','label' => 'Продукт Ид','type' => 'link', 'link' => '/admin/product/{product_id}'],
    ['key'    => 'product.name','label' => 'Продукт'] 
  ];
  protected $inputs = [
    // [
    //   'name'=>'libra',
    //   'caption'=>'Весы',
    //   'type'=>"select",
    //   'list'=> [ 
    //     ['id'=>1, 'name'=>'1 (рыба)'], 
    //     ['id'=>2,'name'=>'2 (сыпучка)'] 
    //   ],
    //   'required'=>true,
    // ],
    [
      'name'=>'button',
      'caption'=>'Кнопка',
      'type'=>"number",
      'required'=>true,
    ],
    [
      'name'=>'product_id',
      'caption'=>'Продукт',
      'type'=>"number",
      'required'=>true,
    ]
  ];

  //Methods
  public static function updateLibras(){

    //Clear doubles
    self::clearDoubles();

    //Sort libras
    self::sortButtonsByName();

    //Generate files
    self::generateVesiOdinFile();
    

  }

  public static function clearDoubles(){
    $doubles = DB::select("
      SELECT * FROM (
        SELECT COUNT('product_id') AS `count`, product_id FROM libras
        WHERE site IS NULL
        GROUP BY product_id
      ) l
      WHERE `count` > 1
    ");

    if(count($doubles) == 0) return true;

    foreach ($doubles as $key => $double) {
      $libra = Libra::where('product_id',$double->product_id)->first();
      $libra->delete();
    }

    self::log('Doubles deleted', 'warning');

    return true;
    
  }

  public static function generateFiles(){

    //Get produts ids
    $libra = self::jugeGet();
    $ids = $libra->pluck('product_id')->toArray();


    dd($ids);

  }

  public static function generateVesiOdinFile(){

    //Get
    $libra = self::jugeGet(['full_products' => 1]);

    //Set bad buttons
    $fLibras = [];
    $previous_button = false;    
    foreach ($libra as $key => $v) {
      while($previous_button !== false && $previous_button + 1 != $v->button){
        $previous_button++;
        $add = json_decode(json_encode($libra[0]));
        $add->button = $previous_button;
        array_push($fLibras, $add);      
        // dd($add->button);
      }
      
      array_push($fLibras, $v);
      $previous_button = $v->button;
    }

    //Make props
    $content = "";
    $previous_button = false;
    foreach ($fLibras as $key => $v) {

      $row = "";

      {//Base props

        {//Name
          //Get prop
          $name = $v->product->name;
          //Get lenght
          $len = iconv_strlen($name);
          //Check errors
          if($len > 79) return ['error' => 1, 'text' => $name . ' Имя не должно превышать 79 символов'];
          //Make prop
          for ($i=0; $i < (80 - $len); $i++) { 
            $name .= ' ';
          }
        }
            
        {//Button
          //Get prop
          $button = $v->button;
          //Get lenght
          $len = iconv_strlen($button);
          //Make prop
          $pre_button = '';        
          for ($i=0; $i < (15 - $len); $i++) { 
            $pre_button .= '0';
          }
          $button = $pre_button . $button;
        }
        
        {//Price
          //Get prop
          $price = ($v->site == 'x') ? $v->product->final_price_x : $v->product->final_price;
          $unit = $v->product->unit;        
          //Make price
          $price_full = number_format((float)((1 / $unit) * $price), 2, '.', '');
          //Get lenght
          $len = iconv_strlen($price_full);
          //Make prop
          $pre = '';
          for ($i=0; $i < (8 - $len); $i++) { 
            $pre .= '0';
          }
          $price = $pre . $price_full;
        }

        {//Make base props row
          $pa1 = 'A220000100000';
          $pa2_button = $button;
          $pa3 = '0001000100';
          $pa4_price = $price;
          $pa5_days = '000';
          $pa6 = '0000';
          $pa7_name = $name;
          $pa8 = "\r\n";
      
          $row .= $pa1.$pa2_button.$pa3.$pa4_price.$pa5_days.$pa6.$pa7_name.$pa8;
        }

      }

      {//Additional props

        $AddProps = [];

        {//Country
          if(isset($v->product->сountry) && $v->product->сountry !== "") {
            $rows = self::addAdditionalRow('Страна', $v->product->сountry);
            $AddProps = array_merge($AddProps,$rows);
          }
        }

        {//Ccal
          if(isset($v->product->calories) && $v->product->calories !== "") {
            $rows = self::addAdditionalRow('Калории', $v->product->calories);
            $AddProps = array_merge($AddProps,$rows);
          }
        }
        
        {//Бжу
          if(
            (isset($v->product->carbohydrates) && $v->product->carbohydrates !== "") &&
            (isset($v->product->proteins) && $v->product->proteins !== "") &&
            (isset($v->product->fats) && $v->product->fats !== "")      
          ) {
            //Get prop
            $carbohydrates = $v->product->carbohydrates;
            $proteins = $v->product->proteins;
            $fats = $v->product->fats;
            //Add row
            $rows = self::addAdditionalRow('БЖУ', "{$proteins}|{$fats}|{$carbohydrates}");
            $AddProps = array_merge($AddProps,$rows);
          }
        }

        {//Composition
          if(isset($v->product->composition) && $v->product->composition !== "") {
            $rows = self::addAdditionalRow('Состав', $v->product->composition);
            $AddProps = array_merge($AddProps,$rows);
          }
        }

        {//Shelf
          if(isset($v->product->shelf_life) && $v->product->shelf_life !== "") {
            $rows = self::addAdditionalRow('Срок годности', $v->product->shelf_life);
            $AddProps = array_merge($AddProps,$rows);
          }
        }        
        
        //Get errors
        if(count($AddProps) > 8){
          
          $error = "Количество дополнительных строк не должно превышать 8!\n";
          $error .= $v->product->name . "\n";
          $error .= "Дополнительные строки:\n";

          foreach ($AddProps as $k => $v) {
            $error .= $k+1 . ') ' . $v . "\n";
          }

          self::log($error, 'danger');

          return false;
        }

        //Add rows
        foreach ($AddProps as $key => $AddProp) {
          $row .= $AddProp."";
        }

      }                  

      //Set previus
      $previous_row = $row;
      $previous_button = $button;
      

      $content .= $row;      
      $content .= "\r\n";      

    }

    //Generate File
    $result = Storage::disk('local')->put('\vesi\odin.txt', mb_convert_encoding($content, "cp866"));

    //Log
    if($result) self::log('"VesiOdin" file generated', 'primary');

    return $result;
  }

  private static function addAdditionalRow($pre, $value){

    //add pre
    $val = $pre. ': ' . strip_tags ($value);   

    //Make rows
    if(iconv_strlen($val) > 48){              
      $left = $val;
      $val = [];
      do{                
        $str = mb_substr  ( $left , 0, 45 );
        $left = mb_substr  ( $left , 45 );                
        array_push($val,$str);                
        if($left == FALSE) break;
      }while(1);
    } 

    //Add rows
    $rows = [];
    if(is_array($val)){
      foreach ($val as $vv) {
        array_push($rows,$vv);
      }
    }else{
      array_push($rows,$val);
    }            

    return $rows;

  }

  public static function log($message, $type = null){
    //Put log
    DB::table('libra_logs')->insert(['body' => $message,'type' => $type,'created_at' => now(),'updated_at' => now()]);
  }

  public static function sortButtonsByName(){

    //Delete Neo
    Libra::where('site','x')->delete();

    //Get
    $libra = self::jugeGet(['site' => 'isNull']);

    //Sort
    $sorted = $libra->sortBy('product.name');

    //Update
    $button = 0;
    foreach ($sorted as $key => $v) {
      Libra::where('id',$v->id)->update(['button' => ++$button]);
    }

    //Log
    self::log('Sort by name', 'info');

    //Neo 
    self::addNeoButtons();
    
    //Return
    return true;
  }

  public static function addNeoButtons(){
    $libras = self::jugeGet(['site' => 'isNull']);
    $maxButton = $libras->max('button');
    $maxButton = (intval($maxButton / 100) + 1) * 100;

    foreach ($libras as $key => $libra) {
      $button = $libra->button;
      $button += $maxButton;
      Libra::where('button',$button)->where('site','x')->delete();
      Libra::insert([
        'libra' => $libra->libra,
        'button' => $button,
        'product_id' => $libra->product_id,
        'site' => 'x',
      ]);
    }

    self::log('Add neo buttons', 'info');

  }


  //Juge CRUD
  public static function jugeGet($request = []) {
    //Model
    $query = new self;

    {//With
      if(!isset($request['full_products'])){
        $query = $query->with('product');
      }      
    }

    {//Where
      if(isset($request['site'])){
        if($request['site'] == 'isNull'){
          $query = $query->whereNull('site');
        }else{
          $query = $query->where('site',$request['site']);
        }        
      }
    }

    {//Sort
      $query = $query->orderBy('button');
    }

    //Get
    $data = JugeCRUD::get($query,$request);

    //Get full products
    if(isset($request['full_products'])){
      $ids = $data->pluck('product_id')->toArray();
      $products = Product::jugeGet(['get_all' => 1, 'ids' => $ids]);
      foreach ($data as $libra) {
        foreach ($products as $product) {
          if($libra->product_id == $product->id){
            $libra->product = $product;
          }
        }
      }
    }

    //Single
    if(isset($request['id'])){$data = $data[0];}

    //Return
    return $data;
  }

  public function jugePost($data){
    //Validate
    $validate = [
      'id'              => ['exists:libras,id'],
      'product_id'      => ['exists:products,id'],
      // 'libra'           => ['numeric'],

      'button'          => ['numeric','min:1','unique:libras,button']
    ];  
    Validator::make($data, $validate)->validate();

    //Update
    $libra = Libra::where('id',$data['id'])->first();
    $update = $libra->update($data);

    //Return
    if($update){
      Libra::log('libra post', 'info');
      return $libra;
    }else{
      return false;
    }
    
  }
  
  public function jugeGetKeys()     {return $this->keys;}    
  public function jugeGetInputs()   {return $this->inputs;}     


  //Relations
  public function product()
  {
    return $this->belongsTo('App\Product');
  }


}


