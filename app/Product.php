<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\ArchiveProduct;
use App\ProductMeta;
use App\ProductLongMeta;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Product extends Model
{

  protected $guarded = [];

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/product/{id}'],
    ['key'    => 'name','label' => 'Название'],    
    ['key'    => 'price','label' => 'Цена'],
    ['key'    => 'unit_view','label' => 'Единица'],
    ['key'    => 'unit','label' => 'Единица (сис)'],
    ['key'    => 'description','label' => 'Описание'],
    ['key'    => 'from','label' => 'Страна'],
    ['key'    => 'gruzka_priority','label' => 'Приоретет погрузки'],
    ['key'    => 'strews','label' => 'Сыпучка'],
    ['key'    => 'updated_at','label' => 'Обнавлён'],    
    ['key'    => 'created_at','label' => 'Создан'],
  ];

  protected $inputs = [
      [
        'name' => 'images',
        'caption' => 'Фото',
        'type' => 'file',
        'fileMax' => 8,
      ],
      [
        'name' => 'name',
        'caption' => 'Название',
        'required' => true,
      ],
      [
        'name' => 'price',
        'caption' => 'Цена',
        'type' => 'number',
        'required' => true,
      ],
      [
        'name' => 'unit_view',
        'caption' => 'Единица',
      ],
      [
        'name' => 'unit',
        'caption' => 'Единица системная',
        'type' => 'float'
      ],
      [
        'name' => 'description',
        'caption' => 'Описание',
        'type' => 'textEditor'
      ],
      [
        'name' => 'composition',
        'caption' => 'Состав',
        'type' => 'textEditor'
      ],
      [
        'name' => 'benefit',
        'caption' => 'Польза',
        'type' => 'textEditor'
      ],
      [
        'name' => 'calories',
        'caption' => 'Калории',
        'type' => 'number'
      ],
      [
        'name' => 'carbohydrates_slow',
        'caption' => 'Углеводы медленные',
        'type' => 'number'
      ],
      [
        'name' => 'carbohydrates_fast',
        'caption' => 'Углеводы быстрыее',
        'type' => 'number'
      ],
      [
        'name' => 'proteins',
        'caption' => 'Белки',
        'type' => 'number'
      ],
      [
        'name' => 'fats',
        'caption' => 'Жиры',
        'type' => 'number'
      ],
      [
        'name' => 'сountry',
        'caption' => 'Страна',
      ],
      [
        'name' => 'no_gluten',
        'caption' => 'Без глютена',
        'type' => 'checkbox'
      ],
      [
        'name' => 'no_lactose',
        'caption' => 'Без лактозы',
        'type' => 'checkbox'
      ],
      [
        'name' => 'no_sugar',
        'caption' => 'Без сахара',
        'type' => 'checkbox'
      ],
      [
        'name' => 'no_heat',
        'caption' => 'Без термической обработки',
        'type' => 'checkbox'
      ],
      [
        'name' => 'no_egg',
        'caption' => 'Без яиц',
        'type' => 'checkbox'
      ],
      [
        'name' => 'low_glycemic',
        'caption' => 'Низкий гликемический индекс',
        'type' => 'checkbox'
      
      ],
      [
        'name' => 'eco',
        'caption' => 'Эко сертификат',
        'type' => 'checkbox'
      ],
      [
        'name' => 'gruzka_priority',
        'caption' => 'Приоритет погрузки',
        'type' => 'number'
      ],
      [
        'name' => 'sort',
        'caption' => 'Приоритет сортировки',
        'type' => 'number'
      ],
      [
        'name' => 'strews',
        'caption' => 'Сыпучка',
        'type' => 'number'
      ],  

  ];

  protected static function getNoMainImage($ids){

    $path = public_path() . '/products/images/main';
    $files = scandir($path);
        
    foreach ($ids as $k => $id) {
      foreach ($files as $file) {
        if(strpos($file,$id.'.') !== false){
          unset($ids[$k]);
          continue 2; 
        }          
      }    
    }

    return $ids;

  }

  public static function getWithOptions($request){

    
    //No main image
    if(isset($request['no_main_image']) && $request['no_main_image']){

      $ids = Product::pluck('id')->toArray();
      $ids = self::getNoMainImage($ids);
      $request['ids'] = $ids;
    }

    //Pre settings
    isset($request['short_query']) ? $request['short_query'] = true : $request['short_query'] = false;
      
    //New Product
    $products = new Product();

    //Withs
    if("WITH" == "WITH"){

      //Metas
      if(!$request['short_query'] || isset($request['with_metas'])){
        $products = $products->with('metas');
        $products = $products->with('longMetas');
      }      
      
      //Description
      if(!$request['short_query'] || isset($request['with_description'])){
        $products = $products->with('description');
      }

      //Discounts
      if(!$request['short_query'] || isset($request['with_final_price'])){
        $products = $products->with('discount');
      }
      
      //Discounts
      if(!$request['short_query'] || isset($request['categories'])){
        $products = $products->with('categories');
      }
      
    }

    //Wheres
    if("WHERE" == "WHERE"){
      //Id
      if(isset($request['id'])){
        $products = $products->where('id', $request['id']);
      }

      //Ids
      if(isset($request['ids']) && is_array($request['ids'])){
        $products = $products->wherein('id',$request['ids']);
      }

      //Search
      if(isset($request['search']) && strlen($request['search']) > 0){
        $search = $request['search'];
        $products = $products->where(function($q)use($search) {
          $q->where('id', $search)
            ->orWhere('name', 'LIKE', '%'.$search.'%');
        });
      }

      //Categories
      if(isset($request['category']) && $request['category'] > 0){
        $categoryId = $request['category'];
        $products = $products->whereHas('categories', function ($q)use($categoryId) {
          $q->where('categoty_id', '=', $categoryId);
        });
      }      

      //Price
      if((isset($request['price_from']) && $request['price_from'] > 0) || (isset($request['price_to']) && $request['price_to'] > 0)){
        $d['from'] = isset($request['price_from']) ? $request['price_from'] : 0;
        $d['to'] = isset($request['price_to']) ? $request['price_to'] : 99999;
        $products = $products->where('price', '>=', $d['from'])->where('price', '<=', $d['to']);
      }

      //КБЖУ
      do{
        //Сalories
        if((isset($request['cal_from']) && $request['cal_from'] > 0) || (isset($request['cal_to']) && $request['cal_to'] > 0)){
          $d['from'] = isset($request['cal_from']) ? $request['cal_from'] : 0;
          $d['to'] = isset($request['cal_to']) ? $request['cal_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'calories')
              ->where('value', '>=', $d['from'])
              ->where('value', '<=', $d['to']);
          });
        }  

        //Proteins
        if((isset($request['prot_from']) && $request['prot_from'] > 0) || (isset($request['prot_to']) && $request['prot_to'] > 0)){
          $d['from'] = isset($request['prot_from']) ? $request['prot_from'] : 0;
          $d['to'] = isset($request['prot_to']) ? $request['prot_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'proteins')
              ->where('value', '>=', $d['from'])
              ->where('value', '<=', $d['to']);
          });
        }  

        //Fats
        if((isset($request['fat_from']) && $request['fat_from'] > 0) || (isset($request['fat_to']) && $request['fat_to'] > 0)){
          $d['from'] = isset($request['fat_from']) ? $request['fat_from'] : 0;
          $d['to'] = isset($request['fat_to']) ? $request['fat_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'fats')
              ->where('value', '>=', $d['from'])
              ->where('value', '<=', $d['to']);
          });
        }  

        //carbohydrates
        if((isset($request['carb_from']) && $request['carb_from'] > 0) || (isset($request['carb_to']) && $request['carb_to'] > 0)){
          $d['from'] = isset($request['carb_from']) ? $request['carb_from'] : 0;
          $d['to'] = isset($request['carb_to']) ? $request['carb_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'carbohydrates_fast')
              ->where('value', '>=', $d['from'])
              ->where('value', '<=', $d['to']);
          });
        }  


      }while(0);

      //Noties
      do{
        //No egg
        if(isset($request['no_egg']) && $request['no_egg'] && $request['no_egg'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_egg')->where('value', '=', '1');
          });
        }  
        //No lactose
        if(isset($request['no_lactose']) && $request['no_lactose'] && $request['no_egg'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_lactose')->where('value', '=', '1');
          });
        }  
        //No sugar
        if(isset($request['no_sugar']) && $request['no_sugar'] && $request['no_egg'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_sugar')->where('value', '=', '1');
          });
        }      
      }while(0);

    }

    //Order By
    if("SORT" == "SORT"){

      if(isset($request['sort'])){
        if($request['sort'] == 'sortCheap'){
          $products = $products->orderBy('price', 'ASC');
        }
        if($request['sort'] == 'sortExpensive'){
          $products = $products->orderBy('price', 'DESC');
        }      
      }           

    }

    //Get
    if(isset($_GET['page'])){
      $products = $products->paginate(15);
    }else{
      $products = $products->get();
    }
    

    //After query work
    if("afterQuery" == "afterQuery"){

      //Images
      if(!$request['short_query'] || isset($request['with_images'])){
        foreach ($products as $product) {
          $product->images = self::getImages($product->id);
          $product->mainImage = self::getMainImage($product->id);
        }
      }

      //Metas
      if(!$request['short_query'] || isset($request['with_metas'])){        
        foreach ($products as $product) {
          //Metas
          foreach ($product['metas'] as $meta) {
            $product[$meta->name] = $meta->value;
          }
          unset($product['metas']);
          //Long Metas
          foreach ($product['longMetas'] as $meta) {
            $product[$meta->name] = $meta->value;
          }
          unset($product['longMetas']);
        }
      }

      if(isset($product->description)){
        $description = $product->description->value;
        unset($product->description);
        $product['description'] = $description;
      }


      //Final price
      if(!$request['short_query'] || isset($request['with_final_price'])){
        foreach ($products as $product) {
          $product->final_price = $product->price;
          //Discount exist
          if(isset($product->discount) && $product->discount){
            $product->final_price = $product->discount->discount_price;
          }

          $product->final_price = $product->final_price;
        }
      }

    }

    //Single
    if(isset($request['id'])){
      $products = $products[0];
    }


    return $products;
  }

  public static function getImages($id){

    $path = public_path() . '/products/images/source';
    $files = scandir($path);

    $rFiles = [];
    foreach ($files as $file) {
      if(strpos($file,$id.'_') === 0){
        array_push($rFiles,'/products/images/source/' .$file);
      }      
    }

    return $rFiles;

  }

  public static function getMainImage($id){

    $xpath = '/products/images/main';
    $path = public_path() . $xpath;
    $files = scandir($path);
    
    $image = false;
    foreach ($files as $file) {
      if(strpos($file,$id.'.') === 0){
        $image = $xpath .'/'. $file;
        break;
      }
    }

    if(!$image) $image = $xpath .'/no-image.png';

    return $image;

  }

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
      $path = public_path().'/products/images/source/';
      $name = FileUpload::generateFileName($path,$productId);

      //Save Image
      if(!FileUpload::saveFile($image,$path.$name)){
        return false;
      }
    }
    return true;
    
  }

  public static function doValidate($request){

    Validator::make($request['data'], [
      'name'                  => 'required|unique:products|max:50',
      'price'                 => 'required|numeric',
      'unit'                  => 'max:50',
      'unit_sys'              => 'numeric',
      'calories'              => 'numeric',
      'carbohydrates_slow'    => 'numeric',
      'carbohydrates_fast'    => 'numeric',
      'proteins'              => 'numeric',
      'fats'                  => 'numeric',
      'сountry'               => 'max:50',
      'composition'           => 'max:65000',
      'benefit'               => 'max:65000',
      'no_gluten'             => 'boolean',
      'no_lactose'            => 'boolean',
      'no_sugar'              => 'boolean',
      'no_heat'               => 'boolean',
      'no_egg'                => 'boolean',
      'low_glycemic'          => 'boolean',
      'eco'                   => 'boolean',
      'gruzka_priority'       => 'numeric',
      'strews'                => 'numeric'
    ])->validate();

  }

  public static function doValidatePost($request){

    Validator::make($request['data'], [
      'name'                  => 'unique:products|max:50',
      'price'                 => 'numeric',
      'unit'                  => 'max:50',
      'unit_sys'              => 'numeric',
      'calories'              => 'numeric',
      'carbohydrates_slow'    => 'numeric',
      'carbohydrates_fast'    => 'numeric',
      'proteins'              => 'numeric',
      'fats'                  => 'numeric',
      'сountry'               => 'max:50',
      'composition'           => 'max:65000',
      'benefit'               => 'max:65000',
      'no_gluten'             => 'boolean',
      'no_lactose'            => 'boolean',
      'no_sugar'              => 'boolean',
      'no_heat'               => 'boolean',
      'no_egg'                => 'boolean',
      'low_glycemic'          => 'boolean',
      'eco'                   => 'boolean',
      'gruzka_priority'       => 'numeric',
      'strews'                => 'numeric'
    ])->validate();

  }

  public static function put($data){
    $product = new Product();
    $id = self::insert($product,$data);
    return $id;
  }

  public static function post($id,$data){
    $product = Product::find($id);
    $id = self::insert($product,$data);
    return $id;
  }

  protected static function insert($product,$data){

    //Sort data
    $insert['product'] = [];
    $insert['meta'] = [];
    $insert['long_meta'] = [];
    $insert['description'] = false;
    $insert['image'] = false;
    foreach ($data as $key => $value) {
      switch ($key) {
        case 'name':
        case 'price':
        case 'unit':
          $insert['product'][$key] = $value;
          break;
        case 'unit_view':
        case 'calories':  
        case 'carbohydrates_slow':  
        case 'carbohydrates_fast':  
        case 'proteins':  
        case 'fats':  
        case  "сountry": 
        case  "no_gluten": 
        case  "no_lactose": 
        case  "no_sugar": 
        case  "no_heat": 
        case  "no_egg": 
        case  "low_glycemic": 
        case  "eco": 
        case  "gruzka_priority": 
        case  "strews": 
        case  "bonus": 
          $insert['meta'][$key] = $value;
          break;
        case "composition": 
        case "benefit": 
          $insert['long_meta'][$key] = $value;
          break;
        case "description": 
          $insert['description'] = $value;
          break;
        case "images": 
          $insert['image'] = $value;
          break;
        default:          
          // dump($key);
          break;
      }
    }

    //Insert
    try {
      DB::beginTransaction();

      //Product
      foreach ($insert['product'] as $k => $v) $product->$k = $v;
      $product->save();

      //Description
      if($insert['description']){
        DB::table('product_descriptions')->where('product_id', $product->id)->delete();
        DB::table('product_descriptions')->insert(['product_id' => $product->id, 'value' => $insert['description']]);
      }
      
      //Meta
      foreach ($insert['meta'] as $k => $v){
        
        ProductMeta::where('product_id', $product->id)->where('name', $k)->delete();
        $meta = new ProductMeta;
        $meta->product_id = $product->id;
        $meta->name = $k;
        $meta->value = $v === true ? 1 : $v;
        $meta->save();

      }
      
      //Long Meta
      foreach ($insert['long_meta'] as $k => $v){
        
        ProductLongMeta::where('product_id', $product->id)->where('name', $k)->delete();
        $meta = new ProductLongMeta;
        $meta->product_id = $product->id;
        $meta->name = $k;
        $meta->value = $v === true ? 1 : $v;
        $meta->save();

      }

      if($insert['image']){
        if(!self::saveImages($insert['image'], $product->id)){
          throw new Exception('error save file');
        }        
      }
      
      
      //Store to DB
      DB::commit();    
    } catch (Exception $e) {          
      // Rollback from DB
      DB::rollback();
      return response(['code' => 'pr1','text' => 'Insert error'], 512)->header('Content-Type', 'text/plain');
    }

    return $product->id;
  }

  public static function setDiscount($data){
    //Delete old
    self::deleteDiscount($data['product_id']);

    //Put new
    $discount = new ProductDiscount;
    $discount->product_id = $data['product_id'];
    $discount->discount_price = $data['discount_price'];
    $discount->quantity = isset($data['quantity']) ? $data['quantity'] : 0;
    $discount->type = isset($data['type']) ? $data['quantity'] : 1;
    $discount->save();
  }  

  public static function deleteDiscount($productId){
    ProductDiscount::where('product_id', $productId)->delete();
  }

  //JugeCRUD
  public function jugeGet($request) {return $this->getWithOptions($request);}
  public function jugeGetKeys()     {return $this->keys;}    
  public function jugeGetInputs()   {return $this->inputs;}    


  //Relations
  public function metas(){
      return $this->hasMany('App\ProductMeta');
  }   
  public function longMetas(){
      return $this->hasMany('App\ProductLongMeta');
  }  
  public function description(){
      return $this->hasOne('App\ProductDescription');
  }  
  public function categories(){
      return $this->belongsToMany('App\Category','products_categories','product_id','categoty_id');
  }
  public function items(){
      return $this->hasMany('App\Item');
  }
  public function archive(){
      return $this->hasMany('App\ArchiveProduct');
  }  
  public function discount(){
      return $this->hasOne('App\ProductDiscount');
  } 
  public function goods(){
      return $this->hasMany('App\Goods');
  }   
  public function suppliers(){
    return $this->belongsToMany('App\Supplier')
    ->withPivot('supplier_product_id', 'created_at');
  }
}
