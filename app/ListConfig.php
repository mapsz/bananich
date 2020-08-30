<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListConfig extends Model
{
  protected $order = [
    ['name'    => 'id','caption' => '#','type' => 'link', 'link' => '/order/{id}'],
    ['name'    => 'address','caption' => 'адрес'], 
    ['name'    => 'appartPorch','caption' => 'кв. п.'], 
    ['name'    => 'appart', 'caption' => 'квартира'],    
    ['name'    => 'porch', 'caption' => 'подъезд'],    
    ['name'    => 'name', 'caption' => 'имя'],  
    ['name'    => 'phone', 'caption' => 'номер'], 
    ['name'    => 'email', 'caption' => 'емэил'],    
    ['name'    => 'status', 'caption' => 'статус'],
    ['name'    => 'comment', 'caption' => 'коммент клиент'],
    ['name'    => 'comment_our', 'caption' => 'коммент бананыч'],
    ['name'    => 'confirm', 'caption' => 'тип потверждение','type' => 'intToStr', 'intToStr' =>[
      1 => 'телефон',
      0 => 'емэил'
    ]],
    ['name'    => 'date', 'caption' => 'дата'],
    ['name'    => 'delivery_date', 'caption' => 'дата доставки'],
    ['name'    => 'delivery_time_from', 'caption' => 'время доставки от'],
    ['name'    => 'delivery_time_to', 'caption' => 'время доставки до'],    
    ['name'    => 'items', 'caption' => 'товары','type' => 'count'],
    // ['name'    => 'discounts', 'caption' => 'скидки'],
    ['name'    => 'discounts_total', 'caption' => 'скидки всего(Предварительно)'],
    ['name'    => 'discounts_total_result', 'caption' => 'скидки всего(Погружено)'],
    ['name'    => 'items_subtotal', 'caption' => 'Подытог без учёта скидок(Предварительно)'],
    ['name'    => 'items_subtotal_result', 'caption' => 'Подытог без учёта скидок(Погружено)'],
    ['name'    => 'items_total', 'caption' => 'Подыто(Предварительно)'],
    ['name'    => 'items_total_result', 'caption' => 'Подыто(Погружено)'],
    ['name'    => 'shipping', 'caption' => 'цена доставки'],
    ['name'    => 'bonus', 'caption' => 'бонусы'],
    ['name'    => 'total', 'caption' => 'Итог(Предварительно)'],
    ['name'    => 'total_result', 'caption' => 'Итог(Погружено)'],
    ['name'    => 'pay_method', 'caption' => 'Метод оплаты'],
  ];

  protected $goods = [
    ['name'    => 'id','caption' => '#'],
    ['name'    => 'product.name','caption' => 'наименование'],
    ['name'    => 'quantity','caption' => 'количество'],
    ['name'    => 'price','caption' => 'цена закупка'],
    ['name'    => 'product.price','caption' => 'цена продажа'],
    ['name'    => 'product.unit','caption' => 'за единицу'],
    ['name'    => 'comment','caption' => 'комментарий'],
    ['name'    => 'created_at','caption' => 'дата']
  ];

  protected $strews = [
    ['name'    => 'id','caption' => '#'],   
    ['name'    => 'strews','caption' => 'сыпучка'],
    ['name'    => 'order_id','caption' => '#','type' => 'link', 'link' => '/order/{order_id}'],
    ['name'    => 'name','caption' => 'наименование'],
    ['name'    => 'quantity_want','caption' => 'количество'],
  ];

  protected $statisticsOrder = [
    ['name'    => 'count','caption' => 'Количество заказов'],   
    ['name'    => 'with_bonus','caption' => 'Заказы с бонусами'],   
    ['name'    => 'total','caption' => 'Сумма(Предварительно)'],   
    ['name'    => 'avg_total','caption' => 'Средняя Сумма(Предварительно)'],
    ['name'    => 'total_result','caption' => 'Сумма(Погружено)'],
    ['name'    => 'avg_total_result','caption' => 'Средняя Сумма(Погружено)'],
    ['name'    => 'bonus','caption' => 'Сумма бонусы'],
    ['name'    => 'avg_bonus','caption' => 'Средняя бонусы'],
    ['name'    => 'discounts_total','caption' => 'Сумма скидки'],
    ['name'    => 'avg_discounts_total','caption' => 'Средня скидкия']
  ];

  protected $statisticsProducts = [
    ['name'    => 'product_id','caption' => '№'],   
    ['name'    => 'name','caption' => 'Наименование'],   
    ['name'    => 'quantity','caption' => 'Количество единицы(Предварительно)'],
    ['name'    => 'quantity_want','caption' => 'Количество кг\шт(Предварительно)'],
    ['name'    => 'quantity_result','caption' => 'Количество кг\шт(Погружено)'],
    ['name'    => 'discounts','caption' => 'Скидки(Предварительно)'],
    ['name'    => 'discounts_result','caption' => 'Скидки(Погружено)'],
    ['name'    => 'price_final','caption' => 'Сумма(Предварительно)'],
    ['name'    => 'price_final_result','caption' => 'Сумма(Погружено)'],
  ];

  protected $suppliers = [
    ['name'    => 'id','caption' => '#','type' => 'link', 'link' => '/report/supplier/{id}'],
    ['name'    => 'name','caption' => 'Название','type' => 'link', 'link' => '/report/supplier/{id}'],
    ['name'    => 'address','caption' => 'Адрес'],
    ['name'    => 'comment','caption' => 'Комментарий'],
    ['name'    => 'contact_name','caption' => 'Имя'],
    ['name'    => 'contact_phone','caption' => 'Номер телефона'],
    ['name'    => 'contact_more','caption' => 'Дополнительно'],
    ['name'    => 'products', 'caption' => 'Товары','type' => 'count'],
  ];

  protected $purchases = [
    ['name'    => 'id','caption' => '#'],
    ['name'    => 'product.name','caption' => 'Продукт'],
    ['name'    => 'quantity','caption' => 'количество'],
    ['name'    => 'price','caption' => 'цена закупка'],
    ['name'    => 'supplier.name','caption' => 'поставщик'],
    ['name'    => 'comment','caption' => 'комментарий'],
    ['name'    => 'user.name','caption' => 'пользователь'],
  ];

  protected $report = [
    ['name'    => 'product_id','caption' => '#','type' => 'link', 'link' => '/product/{product_id}'],
    ['name'    => 'product.name','caption' => 'Продукт'],
    ['name'    => 'product.unit','caption' => 'Единица'],
    ['name'    => 'product.unit_sys','caption' => 'Единица (сис.)'],
    ['name'    => 'suppliers','caption' => 'Поставщики','type' => 'list'],
    ['name'    => 'summary','caption' => 'Остаток'],
    ['name'    => 'ordered','caption' => 'Заказано'],
    ['name'    => 'ready','caption' => 'Погружено'],
    ['name'    => 'summary_total','caption' => 'Остаток Итог'],
  ];

  protected $products = [
    ['name'    => 'id','caption' => '#','type' => 'link', 'link' => '/product/{id}'],
    ['name'    => 'name','caption' => 'Название'],    
    ['name'    => 'price','caption' => 'Цена'],
    ['name'    => 'unit','caption' => 'Единица'],
    ['name'    => 'unit_sys','caption' => 'Единица (сис)'],
    ['name'    => 'description','caption' => 'Описание'],
    ['name'    => 'from','caption' => 'Страна'],
    ['name'    => 'gruzka_priority','caption' => 'Приоретет погрузки'],
    ['name'    => 'strews','caption' => 'Сыпучка'],
    ['name'    => 'updated_at','caption' => 'Обнавлён'],    
    ['name'    => 'created_at','caption' => 'Создан'],
  ];
  
  protected $stocktaking = [
    ['name'    => 'id','caption' => '#','type' => 'link', 'link' => '/product/{id}'],
    ['name'    => 'name','caption' => 'Название'],    
    ['name'    => 'price','caption' => 'Цена'],
    ['name'    => 'unit','caption' => 'Единица'],
    ['name'    => 'unit_sys','caption' => 'Единица (сис)'],
    ['name'    => 'description','caption' => 'Описание'],
    ['name'    => 'from','caption' => 'Страна'],
    ['name'    => 'gruzka_priority','caption' => 'Приоретет погрузки'],
    ['name'    => 'strews','caption' => 'Сыпучка'],
    ['name'    => 'updated_at','caption' => 'Обнавлён'],    
    ['name'    => 'created_at','caption' => 'Создан'],
    ['name'    => 'lastStocktaking','caption' => 'Последний переучёт'],
    [
      'name' => 'doStocktaking','caption' => 'Переучёт',
      'type' => 'custom',
      'component' => 'edit-stocktaking-inline',
    ],
  ];

  protected $purchasePrices = [
    ['name'    => 'id','caption' => '#','type' => 'link', 'link' => '/product/{id}'],
    ['name'    => 'name','caption' => 'Название'],
    ['name'    => 'price','caption' => 'Цена продажи'],
    ['name'    => 'lastPurchaseData','caption' => 'Дата'],
    ['name'    => 'purchases','caption' => 'Закупки','type' => 'list'],
    ['name'    => 'lastPurchasePrice','caption' => 'Цена последней закупки'],
    [
      'name' => 'pId','caption' => '📝',
      'type' => 'custom',
      'component' => 'add-purchase-price',
    ],
  ];
  
  protected function getConfirm(){
    $arr = $this->order;
    array_push($arr, [
      "name" => "doConfirm",
      "caption" => "Подтверждение",
      'type' => 'custom',
      'component' => 'confirm-button',      
    ]);
    return $arr;
  }

  protected function getDelivery(){
    $arr = $this->order;
    array_push($arr, [
      "name" => "deliverier",
      "caption" => "Водитель",
      'type' => 'custom',
      'component' => 'order-deliverier-column',        
    ]);
    return $arr;
  }

  public function get($name){

    //Method or property
    $functionName = 'get'.ucfirst($name);
    if(method_exists($this,$functionName)){
      $config = $this->$functionName();
    }else{
      $config = $this->$name;
    }
    
    return $config;
  }



}
