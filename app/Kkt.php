<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

// Ссылка на личный кабинет https://rarus-cloud.ru/
// логин OK-0668
// пароль Dt58nW2k
// Api-key 421C65F1D0214A568A6F449219371A96

// https://app.swaggerhub.com/apis-docs/rarus-cloud1/RarusOnlineKKTPublic/1.1.4


class Kkt extends Model
{
  public static function test(){

    $client = new Client([
	    'headers' => [
        'API-KEY' => '421C65F1D0214A568A6F449219371A96',
        'accept' => 'application/json',


	    ],
    ]);

    $data = [

        // 'id' => '315DEFA3-EBB3-4A24-8F23-AE709BE81308',
        // example: 315DEFA3-EBB3-4A24-8F23-AE709BE81308
        // Идентификатор документа. Или пустой, или не менеее 32 символов, но неболле 40 из следующих символов 'A'..'Z', '0'..'9','_','-','.'. Если ID не задан, то он будет автоматически создан.
        
        'doc_type' => "sale",
        // *
        // Enum:
        // [ sale, sale_refund, buy, buy_refund ]

        'timestamp_utc' => now()->timestamp,
        // *
        // example: 1501163536
        // Дата документа в формате универсального времени
        
        'timestamp_local' => now()->timestamp,
        // *
        // example: 1501163536
        // Дата документа по-местному времени клиента
        
        // email	string($email)
        // example: customer@gmail.com
        // Почтовый адрес покупателя, обязательно передавать email или phone. Номер телефона не должен содержать спецсимволы, только +7{Цифры}
        
        // phone	string($phone)
        // example: +79781234567
        // Номер телефона покупателя, обязательно передавать email или phone. Номер телефона не должен содержать спецсимволы, только +7{Цифры}
        
        'tax_system' => 'OSN',
        // *
        // example: OSN
        // [ OSN, USN, USNDR, ENVD, ESXN, PSN ]
        // Cистемы налогообложенияCистемы налогообложения
        
        // call_back_uri	string($uri)
        // example: http://www.roga-kopita.org/response
        // Адрес сервиса обратного вызова, если параметр заполнен сервис вернет ответ POST запросом на переданный URI
        
        'inn' => '381802808700',
        //*
        // example: 123456789111
        // ИНН юр. лица. Используется для предотвращения регистрации чеков на ФН зарегистрированным с другим ИНН
        
        // payment_address	string
        // example: www.roga-kopita.org
        // Адрес места расчета.
        
        // payment_place	string
        // example: Ларёк
        // Место расчета.
        
        // machine_number	string
        // example: 41354
        // Номер автомата.
        
        // agent_info	AgentInfo{...}
        // supplier_info	SupplierInfo{...}
        // cashier	string
        // тег 1021
        
        // additional_check_props	string
        // тег 1192
        
        // customer_info	string
        // тег 1227 Покупатель
        
        // customer_inn	string
        // тег 1228 ИНН покупателя
        
        // tag_1085	string
        // наименование дополнительного реквизита пользователя
        
        // tag_1086	string
        // значение дополнительного реквизита пользователя
        
        'items' => [
          [
            "name" => "Товар 1",
            "price" => 20.00,
            "quantity" => 2,
            "sum" => 40.00,
            "tax" => "none",
            // [ none, vat0, vat10, vat20, vat110, vat120 ]
            "tax_sum" => 0.00,
            "sign_method_calculation" => "full_prepayment",
            // [ full_prepayment, prepayment, advance, full_payment, partial_payment, credit, credit_payment ]
            // Признак способа расчета
            "sign_calculation_object" => "commodity"
            // [ commodity, excise, job, service, gambling_bet, gambling_prize, lottery, lottery_prize, intellectual_activity, payment, agent_commission, composite, another, property_right, non_operating_gain, insurance_premium, sales_tax, resort_fee ]
            // Признак предмета расчета
          ],
        ],
        // *
        // minItems: 1
        // example: List [ OrderedMap { "name": "Товар 1", "price": 10.99, "quantity": 2, "sum": 21.98, "tax": "vat18", "tax_sum": 3.956, "sign_method_calculation": "full_prepayment", "sign_calculation_object": "commodity" }, OrderedMap { "name": "Товар 2", "price": 5.99, "quantity": 3.342, "sum": 2.02, "tax": "vat18", "tax_sum": 3.6, "sign_method_calculation": "full_prepayment", "sign_calculation_object": "commodity" } ]

        // credit	number
        // example: 60.89
        // Кредит
        
        // advance_payment	number
        // example: 60.89
        // Аванс
        
        'total' => 40.00
        // *
        // total	number
        // example: 60.89
        // Электронная оплата.
        
        // cash	number
        // Сумма наличными
        
        // barter	number
        // Сумма встречного представления
    ];

    dump($data);

    // $get = $client->request('GET', 'kkm.rarus-cloud.ru/versions');
    $get = $client->request('POST', 'https://kkm.rarus-cloud.ru/v1/document',['http_errors' => false,'json' => $data]);

    dump($get);
    dump($get->getBody());
    dd($get->getBody()->getContents());
  }



}
