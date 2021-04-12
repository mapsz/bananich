<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\ArchiveProduct;
use App\ProductMeta;
use App\ProductLongMeta;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Goods;
use App\Item;
use Intervention\Image\Facades\Image;

class Product extends Model
{

  protected $guarded = [];

  protected $keys = [
    ['key'    => 'id','label' => '#','type' => 'link', 'link' => '/admin/product/{id}'],
    ['key'    => 'name','label' => 'Название'],    
    ['key'    => 'composition','label' => 'Состав'],    
    ['key'    => 'available','label' => 'Доступно'],    
    ['key'    => 'price','label' => 'Цена'],
    ['key'    => 'unit_view','label' => 'Единица'],
    ['key'    => 'unit','label' => 'Единица (сис)'],
    ['key'    => 'description','label' => 'Описание'],
    ['key'    => 'сountry','label' => 'Страна'],
    ['key'    => 'gruzka_priority','label' => 'Приоретет погрузки'],
    ['key'    => 'short_info','label' => 'Доп. инфа'],
    ['key'    => 'strews','label' => 'Сыпучка'],

    ['key'    => 'calories','label' => 'Калории'],
    ['key'    => 'carbohydrates','label' => 'Углеводы'],
    ['key'    => 'proteins','label' => 'Белки'],
    ['key'    => 'fats','label' => 'Жиры'],

    
    [
      'key'    => 'categories',
      'label' => 'Категории',
      'type' => 'list',
      'show' => 'name',
    ],
    
    ['key'    => 'always_publish','label' => 'всегда опубликован'],
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
        'name' => 'unit_type',
        'caption' => 'Тип единицы',
        'type'=>"select",
        'list'=> [ 
          ['id'=>'kg',    'name'=>'Килограммы'], 
          ['id'=>'l',     'name'=>'Литры'],
          ['id'=>'piece', 'name'=>'Штуки'] 
        ],
      ],
      [
        'name' => 'unit_full',
        'caption' => 'Единица полный вес',
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
        'name' => 'carbohydrates',
        'caption' => 'Углеводы',
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
        'name' => 'no_milk',
        'caption' => 'Без молока',
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
      [
        'name' => 'short_info',
        'caption' => 'Доп. инфа',
      ],
      [
        'name' => 'shelf_life',
        'caption' => 'Срок годности',
      ],  

  ];

  public static function mainPhotosCompres(){

    $savePath = public_path() . '/products/images/main-';
    $path = public_path() . '/products/images/main';    
    $files = scandir($path);

    

    foreach ($files as $key => $file) {
      if($file == '.' || $file == '..' || strpos($file,'no-image') !== false) continue;

      $img = Image::make($path .'/'. $file);
      
      dump(
        count($files) - $key . ' -  ' .
        $img->filename . '  ' .
        $img->mime . '  ' .
        $img->extension . '  ' 

      );    

      $img->save($savePath.'50/' . $img->filename.'.jpg',50,'jpg');
      $img->save($savePath.'60/' . $img->filename.'.jpg',60,'jpg');
      $img->save($savePath.'70/' . $img->filename.'.jpg',70,'jpg');
      $img->save($savePath.'80/' . $img->filename.'.jpg',80,'jpg');
      $img->save($savePath.'90/' . $img->filename.'.jpg',90,'jpg');
    }


    return true;

  }

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

  public static function checkProductAvailable($id, $date){

    //Get product time
    $beforeDeliveryTimes = ProductMeta::where('product_id',$id)->where('name', '=', 'deliveryTime')->first();

    //Skip if no time
    if($beforeDeliveryTimes == null) return true;

    //Get timespamps
    $deliveryTS = Carbon::parse($date)->timestamp;
    $productAvailableTS = now()->addHours($beforeDeliveryTimes->value)->timestamp;
    
    //Compare
    if($productAvailableTS > $deliveryTS) return false;

    return true;
  }

  public static function checkCartAvailable($cart){

    //Get ids
    $ids = [];
    foreach ($cart['items'] as $key => $item) {array_push($ids,$item['product_id']);}

    // self::updateAvailable($ids);
    $products = self::getWithOptions(['ids' => $ids]);

    foreach ($products as $key => $product) {
      foreach ($cart['items'] as $key => $item) {
        if($product->id == $item['product_id']){
          if($product->always_publish) continue;
          if(intval($item['count']) > intval($product->available_unit)){
            return [
              'r' => false,
              'product' => $product->id,
              'name' => $product->name,
              'leftUnit' => intval($product->available_unit) 
            ];
          }
        }
      }
    }

    return ['r' => true];

  }

  public static function updateAvailable($ids){

    $all = $ids;
    if($ids == 'all') $ids = Product::pluck('id')->all();
    if(!is_array($ids))$ids = [$ids];

    foreach ($ids as $key => $id) {
      $reserve = floatval (Product::getInReserve($id)['summ']);
      $summary = floatval (Product::getWithOptions(['id' => $id, 'with_summary' => 1])['summary']);
      $available = $summary - $reserve;
      $meta = ProductMeta::where('product_id', $id)->where('name', 'available')->delete();

      $meta = new ProductMeta;
      $meta->name         = 'available';
      $meta->product_id   = $id;
      $meta->value = $available;
      $meta->save();

      if($all == 'all') dump(count($ids) - $key);


    }

    return 1;

  }

  public static function getInReserve($id){
    return Item::getWithOptions(['productId'=>$id,'ItemsInReserve'=>1]);
  }

  public static function getWithOptions($request){

    $timer = microtime(1);
    DB::enableQueryLog();
    
    //No main image
    if(isset($request['no_main_image']) && $request['no_main_image']){
      $ids = Product::pluck('id')->toArray();
      $ids = self::getNoMainImage($ids);
      $request['ids'] = $ids;
    }

    //Catalogue
    if(isset($request['catalogue'])){
      $request['no_long_metas'] = 1;
      $request['no_description'] = 1;
      $request['no_images'] = 1;
    }
      
    //New Product
    $products = new Product();
    
    {//Withs

      //Summary
      if(isset($request['with_summary'])){
        //Last Stocktaking
        $lastStocktaking = (
          DB::table('goods')
          ->selectRaw('product_id,MAX(created_at) AS date')
          ->where('quantity',0)
          ->where('action',1)
          ->groupBy('product_id')
        );
        
        //Goods
        $goods = (
          DB::table('goods')
          ->selectRaw('goods.product_id, SUM(quantity) as summary')
          ->joinSub($lastStocktaking, 'last_stocktaking', function ($join) {
            $join->on('last_stocktaking.product_id', '=', 'goods.product_id');
          })
          ->whereRaw('goods.created_at >= last_stocktaking.date')
          ->groupBy('goods.product_id')
        );

        //Id
        if(isset($request['id'])){
          $lastStocktaking  = $lastStocktaking->where('product_id',$request['id']);
          $goods            = $goods->where('goods.product_id',$request['id']);
        }

        //Ids
        if(isset($request['ids']) && is_array($request['ids'])){
          $lastStocktaking  = $lastStocktaking->whereIn('product_id',$request['ids']);
          $goods            = $goods->whereIn('goods.product_id',$request['ids']);
        }        

        //Join
        $products = $products->leftJoinSub($goods, 'summ', function ($join) {
          $join->on('products.id', '=', 'summ.product_id');
        });        
      }

      //Metas
      if(!isset($request['no_metas'])){
        $products = $products->with('metas');
      }      

      //Long Metas
      if(!isset($request['no_long_metas'])){
        $products = $products->with('longMetas');
      }

      //Description
      if(!isset($request['no_description'])){
        $products = $products->with('description');
      }

      //Discounts
      $products = $products->with('discounts');
      
      //Categories
      if(!isset($request['no_categories'])){
        $products = $products->with('categories');
      }
      
    }
    
    {//Wheres

      //no Libras
      if(isset($request['noLibras'])){
        $products = $products->orWhereDoesntHave('libras');
      }    

      //Id
      if(isset($request['id'])){
        $products = $products->where('id', $request['id']);
      }

      //No description
      if(isset($request['doesnt_have_description'])){
        $products = $products->doesntHave('description');
      }

      //No price
      if(isset($request['no_price'])){        
        $products = $products->where(function($q){
          $q->whereDoesntHave('metas', function($q2){
            $q2->where('name', '=', 'supply_price');
          })
          ->orWhereDoesntHave('metas', function($q2){
            $q2->where('name', '=', 'charge');
          })
          ->orWhereDoesntHave('metas', function($q2){
            $q2->where('name', '=', 'charge_x');
          });
        });
      }

      //No weight
      if(isset($request['no_weight'])){
        
        $products = $products->where(function($q){
          $q->whereHas('metas', function($q){
            $q->where('name','unit_type')
            ->where('value','piece');
          })
          ->whereDoesntHave('metas', function($q2){
            $q2->where('name', '=', 'unit_full');
          });    
        });    

      } 

      //Shtuki
      if(isset($request['shtuki'])){
        
        $products = $products->whereHas('metas', function($q){
          $q->where('name','unit_type')
          ->where('value','piece');
        });    

      }    

      //No type
      if(isset($request['no_type'])){
        $products = $products->whereDoesntHave('metas', function($q2){
          $q2->where('name', '=', 'unit_type');
        });        
      }      

      //Ids
      if(isset($request['ids']) && is_array($request['ids'])){
        $products = $products->whereIn('id',$request['ids']);
      }

      //Search
      if(isset($request['search']) && strlen($request['search']) > 0){
        $search = $request['search'];
        $products = $products->where(function($q)use($search) {
          $q->where('id', $search)
            ->orWhere('name', 'LIKE', '%'.$search.'%');
        });
      }

      //Category
      if(isset($request['category']) && $request['category'] > 0){
        $categoryId = $request['category'];
        $products = $products->whereIn('id', function ($query)use($categoryId) {
          $query->select('product_id')->from('products_categories')->where('categoty_id', '=', $categoryId);
        });
      }  
      
      //Categories
      if(isset($request['categories']) && is_array($request['categories']) && isset($request['categories'][0]) && $request['categories'][0] > 0){
        $categories = $request['categories'];        
        $products = $products->whereIn('id', function ($query)use($categories) {
          $query->select('product_id')->from('products_categories')->whereIn('categoty_id', $categories);
        });
      }       
      
      //Suppliers
      if(isset($request['suppliers']) && is_array($request['suppliers']) && isset($request['suppliers'][0]) && $request['suppliers'][0] > 0){
        $suppliers = $request['suppliers'];        
        $products = $products->whereIn('id', function ($query)use($suppliers) {
          $query->select('product_id')->from('product_supplier')->whereIn('supplier_id', $suppliers);
        });
      }          

      //Price
      if((isset($request['price_from']) && $request['price_from'] > 0) || (isset($request['price_to']) && $request['price_to'] > 0)){
        $d['from'] = isset($request['price_from']) ? $request['price_from'] : 0;
        $d['to'] = isset($request['price_to']) ? $request['price_to'] : 99999;
        $products = $products->where('price', '>=', intval($d['from']))->where('price', '<=', intval($d['to']));
      }

      //Discounts Only
      if(isset($request['only_discounts']) && $request['only_discounts'] && $request['only_discounts'] != 'false'){
        $products = $products->whereHas('discounts');
      }        

      //КБЖУ
      do{
        //Сalories
        if((isset($request['cal_from']) && $request['cal_from'] > 0) || (isset($request['cal_to']) && $request['cal_to'] > 0)){
          $d['from'] = isset($request['cal_from']) ? $request['cal_from'] : 0;
          $d['to'] = isset($request['cal_to']) ? $request['cal_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'calories')
              ->where('value', '>=', intval($d['from']))
              ->where('value', '<=', intval($d['to']));
          });
        }  

        //Proteins
        if((isset($request['prot_from']) && $request['prot_from'] > 0) || (isset($request['prot_to']) && $request['prot_to'] > 0)){
          $d['from'] = isset($request['prot_from']) ? $request['prot_from'] : 0;
          $d['to'] = isset($request['prot_to']) ? $request['prot_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'proteins')
              ->where('value', '>=', intval($d['from']))
              ->where('value', '<=', intval($d['to']));
          });
        }  

        //Fats
        if((isset($request['fat_from']) && $request['fat_from'] > 0) || (isset($request['fat_to']) && $request['fat_to'] > 0)){
          $d['from'] = isset($request['fat_from']) ? $request['fat_from'] : 0;
          $d['to'] = isset($request['fat_to']) ? $request['fat_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'fats')
              ->where('value', '>=', intval($d['from']))
              ->where('value', '<=', intval($d['to']));
          });
        }  

        //carbohydrates
        if((isset($request['carb_from']) && $request['carb_from'] > 0) || (isset($request['carb_to']) && $request['carb_to'] > 0)){
          $d['from'] = isset($request['carb_from']) ? $request['carb_from'] : 0;
          $d['to'] = isset($request['carb_to']) ? $request['carb_to'] : 99999;
          $products = $products->whereHas('metas', function ($q)use($d) {
            $q->where('name', '=', 'carbohydrates')
              ->where('value', '>=', intval($d['from']))
              ->where('value', '<=', intval($d['to']));
          });
        }  


      }while(0);

      //Bonus
      if(isset($request['bonus']) && $request['bonus'] && $request['bonus'] != 'false'){
        $products = $products->whereHas('metas', function ($q) {
          $q->where('name', '=', 'bonus')->where('value', '=', '1');
        });
      }  

      //Strews
      if(isset($request['strews']) && $request['strews'] && $request['strews'] != 'false'){
        $products = $products->whereHas('metas', function ($q) {
          $q->where('name', '=', 'strews')->where('value', '>', '0');
        });
      }  

      //Popular
      if(isset($request['popular']) && $request['popular'] && $request['popular'] != 'false'){
        $products = $products->whereHas('metas', function ($q) {
          $q->where('name', '=', 'popular')->where('value', '=', '1');
        });
      }  

      //Noties
      do{
        //No egg
        if(isset($request['no_egg']) && $request['no_egg'] && $request['no_egg'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_egg')->where('value', '=', '1');
          });
        }  
        //No lactose
        if(isset($request['no_lactose']) && $request['no_lactose'] && $request['no_lactose'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_lactose')->where('value', '=', '1');
          });
        }  
        //No sugar
        if(isset($request['no_sugar']) && $request['no_sugar'] && $request['no_sugar'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_sugar')->where('value', '=', '1');
          });
        }    
        // No egg
        if(isset($request['no_egg']) && $request['no_egg'] && $request['no_egg'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_egg')->where('value', '=', '1');
          });
        }  
        // no_heat
        if(isset($request['no_heat']) && $request['no_heat'] && $request['no_heat'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_heat')->where('value', '=', '1');
          });
        }    
        // low_glycemic
        if(isset($request['low_glycemic']) && $request['low_glycemic'] && $request['low_glycemic'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'low_glycemic')->where('value', '=', '1');
          });
        }   
        // no_milk
        if(isset($request['no_milk']) && $request['no_milk'] && $request['no_milk'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'no_milk')->where('value', '=', '1');
          });
        }   
        // eco
        if(isset($request['eco']) && $request['eco'] && $request['eco'] != 'false'){
          $products = $products->whereHas('metas', function ($q) {
            $q->where('name', '=', 'eco')->where('value', '=', '1');
          });
        }      
      }while(0);

      //Available
      if(!isset($request['get_all']) && !isset($request['id'])){
        $products = $products
          ->where(function($q0) {
            $q0->where(function($q) {
              $q->whereIn('id', function ($query) {
                $query->select('product_id')->from('product_metas')->where('name', '=', 'always_publish')->where('value', '=', '1');
              });
            })
            ->orWhere(function($q4) {              
              $q4->whereIn('id', function ($query) {
                $query->select('product_id')->from('product_metas')->where('name', '=', 'available')->where('value', '>', '0');
              });
            });
          });
      }

    }
    
    {//Sort
      if(isset($request['sort'])){
        if($request['sort'] == 'sortCheap'){
          $products = $products->orderBy('price', 'ASC');
        }
        if($request['sort'] == 'sortExpensive'){
          $products = $products->orderBy('price', 'DESC');
        } 
      }                 
      $products = $products->orderBy('sort', 'DESC');

    }

    //Get
    $products = JugeCRUD::get($products,$request);
    
    
    {//After query work

      //Images
      if(!isset($request['no_images'])){
        foreach ($products as $product) {
          $product->images = self::getImages($product->id);          
        }
      }

      //Main_Images
      foreach ($products as $product) {
        $product->mainImage = self::getMainImage($product->id);    
      } 
      
      //Product_Images
      if(isset($request['id'])){
        foreach ($products as $product) {
          $product->productImage = self::getProductImage($product->id);
        }
      }

      //Metas
      if(!isset($request['no_metas'])){
        foreach ($products as $product) {
          $product = Product::setMetas($product);
        }
      }

      //Description
      if(isset($product->description)){
        $description = $product->description->value;
        unset($product->description);
        $product['description'] = $description;
      }

      //Discounts
      foreach ($products as $product) {
        $product->discount;
        $product->discount = null;
        if(isset($product->discounts) && isset($product->discounts[0])){
          $product->discount = $product->discounts[0];
        }
      }

      {//Price
        foreach ($products as $product) {

          $unit = !isset($product->unit) || $product->unit <= 0 ? 0 : $product->unit;
          
          {//Normal bananich
            {//Supply Price
              $chargePrice = false;              
              $pack = 0;
              if(
                (isset($product['charge']) && $product['charge'] > 0) &&            //Charge set
                (isset($product['supply_price']) && $product['supply_price'] > 0)   //Supply Price set
              ){
                //Charge
                $chargePrice = $product['charge'] * $product['supply_price'];

                //Pack
                if(isset($product['pack']) && $product['pack'] > 0) $pack = $product['pack'];

                //Transport
                if(isset($product['transport']) && $product['transport'] > 0) {
                  $chargePrice += ($product['supply_price'] * $product['transport']) - $product['supply_price'];
                }
              }

              $product->final_price = ($chargePrice * $unit) + $pack;
            }

            //Static price
            if(!$product->final_price) $product->final_price = $product->price;

          }
          
          {//X bananich
            {//Supply Price
              $xChargePrice = false;
              $pack = 0;
              if(
                (isset($product['charge_x']) && $product['charge_x'] > 0) &&        //Charge X set
                (isset($product['supply_price']) && $product['supply_price'] > 0)   //Supply Price set
              ){
                //Charge
                $xChargePrice = $product['charge_x'] * $product['supply_price'];

                //Pack
                if(isset($product['pack']) && $product['pack'] > 0) $pack = $product['pack'];

                //Transport
                if(isset($product['transport']) && $product['transport'] > 0) {
                  $xChargePrice += ($product['supply_price'] * $product['transport']) - $product['supply_price'];
                }
              }

              $product->final_price_x = ($xChargePrice * $unit) + $pack;
            }

            //Static price
            if(!$product->final_price_x) $product->final_price_x = $product->price_x;

            //Price from normal
            if(!$product->final_price_x) $product->final_price_x = $product->final_price;

          }

          //Discounts
          if(isset($product->discount) && $product->discount){
            $product->final_price = $product->discount->discount_price;
          }

          {//Rounds
            $round = 0;
            $product->price                       = (ceil((($product->price*2)/10))/2)*10;
            $product->final_price                 = (ceil((($product->final_price*2)/10))/2)*10;
            // $product->final_price_x               = (ceil((($product->final_price_x*2)/10))/2)*10;
            $product->final_price_x               = round($product->final_price_x);
            if(isset($product->discount) && $product->discount)
              $product->discount->discount_price  = round($product->discount->discount_price, $round);

          }
        }

      }
      
      //Unit
      foreach ($products as $product) {
        $product->unit             = isset($product->unit) ? $product->unit : 1;
        // $product->unit_view        = isset($product->unit_view) ? $product->unit_view : $product->unit;
        
        //view unit split      
        $product->unit_digit       = preg_replace('/[^0-9]/', '', isset($product->unit_view) ? $product->unit_view : $product->unit);
        $product->unit_name        = preg_replace('/\ /', '', preg_replace('/\d/', '', $product->unit_view));;
      }

      //Available unit
      foreach ($products as $product) {
        if($product->unit == 0){
          $product->available_unit = 0;
        }else{
          $product->available_unit = intval(floatval ($product->available) / floatval ($product->unit));
        }        
      }

    }

    //Single
    if(isset($request['id'])){
      $products = $products[0];
    }

    //Test
    if(isset($request['testz'])){
      dd(
        microtime(true) - $timer, 
        DB::getQueryLog(),
        $products->toArray()['data']
      );
    }

    return $products;
  }

  public static function setMetas($product){
    
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

    return $product;
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

  public static function getProductImage($id){

    $xpath = '/products/images/product';
    $path = public_path() . $xpath;
    $files = scandir($path);
    
    $image = false;
    foreach ($files as $file) {
      if(strpos($file,$id.'.') === 0){
        $image = $xpath .'/'. $file;
        break;
      }
    }

    if(!$image) $image = self::makeProductImage($id);

    if(!$image) $image = $xpath .'/no-image.svg';

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

    // dump($request);


    Validator::make($request['data'], [
      'name'                  => 'required|unique:products|max:50',
      'price'                 => 'required|numeric',
      'unit'                  => 'required|numeric',
      'unit_full'             => 'numeric',
      'unit_type'             => 'string|max:50',
      'calories'              => 'numeric',
      'carbohydrates'         => 'numeric',
      'proteins'              => 'numeric',
      'fats'                  => 'numeric',
      'sort'                  => 'numeric',
      'сountry'               => 'max:50',
      'composition'           => 'max:65000',
      'benefit'               => 'max:65000',
      'no_gluten'             => 'boolean',
      'no_lactose'            => 'boolean',
      'no_sugar'              => 'boolean',
      'no_heat'               => 'boolean',
      'no_egg'                => 'boolean',
      'no_milk'               => 'boolean',
      'low_glycemic'          => 'boolean',
      'eco'                   => 'boolean',
      'gruzka_priority'       => 'numeric',
      'short_info'            => 'string|max:50',
      'shelf_life'            => 'string|max:50',
      'strews'                => 'numeric'
    ])->validate();

  }

  public static function doValidatePost($request){

    Validator::make($request['data'], [
      'name'                  => 'unique:products|max:50',
      'price'                 => 'numeric',
      'unit'                  => 'numeric',
      'unit_full'             => 'numeric',
      'unit_type'             => 'string|max:50',
      'calories'              => 'numeric',
      'carbohydrates'         => 'numeric',
      'proteins'              => 'numeric',
      'fats'                  => 'numeric',
      'sort'                  => 'numeric',
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
      'short_info'            => 'string|max:50',
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
        case 'sort':
          $insert['product'][$key] = $value;
          break;
        case 'unit_view':
        case 'unit_full':
        case 'unit_type':
        case 'calories':  
        case 'carbohydrates':  
        case 'proteins':  
        case 'fats':  
        case  "сountry": 
        case  "no_gluten": 
        case  "no_lactose": 
        case  "no_sugar": 
        case  "no_heat": 
        case  "no_egg": 
        case  "no_milk": 
        case  "low_glycemic": 
        case  "eco": 
        case  "gruzka_priority": 
        case  "short_info": 
        case  "shelf_life": 
        case  "strews": 
        case  "always_publish": 
        case  "bonus": 
        case  "popular": 
        case  "termobox": 
        case  "pack": 
        case  "supply_price": 
        case  "transport": 
        case  "price_x": 
        case  "charge_x": 
        case  "charge": 
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
      $product->updated_at = now();
      $product->save();

      //Description
      if($insert['description']){
        DB::table('product_descriptions')->where('product_id', $product->id)->delete();
        DB::table('product_descriptions')->insert(['product_id' => $product->id, 'value' => $insert['description']]);
      }
      
      //Meta
      foreach ($insert['meta'] as $k => $v){

        {//Value
          $v = $v === true ? 1 : $v;
          $v = $v ==  null ? 0 : $v;
          $v = $v ==  ""   ? 0 : $v;
        }

        //Delete
        ProductMeta::where('product_id', $product->id)->where('name', $k)->delete();

        //Put 
        if($v){          
          $meta = new ProductMeta;
          $meta->product_id = $product->id;
          $meta->name = $k;
          $meta->value = $v;
          $meta->save();
        }
      }
      
      //Long Meta
      foreach ($insert['long_meta'] as $k => $v){

        {//Value
          $v = $v === true ? 1 : $v;
          $v = $v ==  null ? 0 : $v;
          $v = $v ==  ""   ? 0 : $v;
        }
        
        //Delete
        ProductLongMeta::where('product_id', $product->id)->where('name', $k)->delete();

        //Put 
        if($v){
          $meta = new ProductLongMeta;
          $meta->product_id = $product->id;
          $meta->name = $k;
          $meta->value = $v;
          $meta->save();
        }

      }

      //Images
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

  public static function makeProductImage($id){

    $images = self::getImages($id);
    if(count($images) == 0) return false;

    $img = Image::make(public_path() . $images[0]);

    $img->resize(540, null, function ($constraint) {
      $constraint->aspectRatio();
    });

    $img->save(public_path() . '/products/images/product/' . $img->basename);

    if(!$img) return false;

    return '/products/images/product/' . $img->basename;
  }

  public static function setDiscount($id, $data){

    $toData = [];

    //data
    if(isset($data['quantity']))          $toData['quantity']         = $data['quantity'];
    if(isset($data['discount_price']))    $toData['discount_price']   = $data['discount_price'];
    
    //Update
    DB::table('product_discounts')->updateOrInsert(
      ['product_id'  => $id], $toData 
    );

    {//Delete
      //Check discount exists
      foreach ($data as $key => $value) {
        if($key == 'discount_price'){
          $exists = true;
          break;      
        }
      }      

      if($exists && $data['discount_price'] == null){
        ProductDiscount::where('product_id', $id)->delete();
      }
    }

    return 1;
  }  

  public static function deleteDiscount($productId){
    ProductDiscount::where('product_id', $productId)->delete();
  }


  //JugeCRUD
  public static function jugeGet($request = []) {return self::getWithOptions($request);}
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
  public function discounts(){
      return $this->hasMany('App\ProductDiscount');
  }
  public function goods(){
      return $this->hasMany('App\Goods');
  }  
  public function libras(){
      return $this->hasMany('App\Libra');
  }   
  public function suppliers(){
    return $this->belongsToMany('App\Supplier')
    ->withPivot('supplier_product_id', 'created_at');
  }
}
