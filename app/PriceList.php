<?php

namespace App;

use Bukashk0zzz\YmlGenerator\Model\Offer\OfferSimple;
use Bukashk0zzz\YmlGenerator\Model\Category;
use Bukashk0zzz\YmlGenerator\Model\Currency;
use Bukashk0zzz\YmlGenerator\Model\Delivery;
use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Bukashk0zzz\YmlGenerator\Generator;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class PriceList extends Model{
  
  public static function showYandex(){

    $file = tempnam(sys_get_temp_dir(), 'YMLGenerator');
    $settings = (new Settings())
      ->setOutputFile($file)
      ->setEncoding('UTF-8')
    ;
    
    {// Creating ShopInfo object (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#shop)
        $shopInfo = (new ShopInfo())
            ->setName('Neolavka')
            ->setCompany('Neolavka')
            ->setUrl('http://neolavka.ru/')
        ;
    }

    {// Creating currencies array (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#currencies)
        $currencies = [];
        $currencies[] = (new Currency())
            ->setId('RUR')
            ->setRate(1)
        ;
    }

    {// Creating categories array (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#categories)
        $dbCategories = \App\Category::jugeGet();

        $categories = [];
        foreach ($dbCategories as $key => $dCategory) {
            $categories[] = (new Category())
                ->setId($dCategory->id)
                ->setName($dCategory->name)
            ;        
        }
    }

    {// Creating offers array (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#offers)
        $products = Product::jugeGet();

        $offers = [];

        // dd($products[0]);

        foreach ($products as $key => $product) {
          $offer = new OfferSimple();
          $offer = $offer->setId($product->id);
          $offer = $offer->setName($product->name . " " . $product->unit_view);
          $offer = $offer->setPrice($product->final_price_x);
          $offer = $offer->setCurrencyId('RUR');        
          // $offer = $offer->setDelivery(false);
          $offer = $offer->setAvailable(true);
          $offer = $offer->setUrl('http://neolavka.ru/product/' . $product->id);
  
          {//Add categories
            foreach ($product->categories as $key => $category) {
              $offer = $offer->addCustomElement('categoryId_to_rework', $category->id);
            }
          }
  
          $offers[] = $offer;
        }

    }    

    // dd($offers);
    
    {// Optional creating deliveries array (https://yandex.ru/support/partnermarket/elements/delivery-options.xml)
        $deliveries = [];
        // $deliveries[] = (new Delivery())
        //     ->setCost(2)
        //     ->setDays(1)
        //     ->setOrderBefore(14)
        // ;
    }
    
    (new Generator($settings))->generate(
        $shopInfo,
        $currencies,
        $categories,
        $offers,
        $deliveries
    );

    // $file = 'filename';
    file_put_contents($file,str_replace('categoryId_to_rework','categoryId',file_get_contents($file)));
   
    return $file;

  }

}
