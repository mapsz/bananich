@extends('layouts.mail')

@section('content')


{{-- в данных отдельно примененный прромокод выведи плиз, коммент, реферала, спсоб оплаты и упаковки, остальное по данным норм. ТЕкст вот так правим: --}}

<p>Здравствуйте!</p>

<p style="text-align: justify;">Спасибо, что оформили заказ на Бананыче. Он уже в работе и будет доставлен в выбранное вами время. В день доставки в вашем личном кабинете появится информация о более точном времени прибытия курьера и его контактный номер для связи.</p>

Информация по заказу:
<div>Заказ №<b>{{$order['id']}}</b></div>
<div>{{$order['delivery_date']}}</div>
<div>{{$order['delivery_time_from']}} - {{$order['delivery_time_to']}}</div>
<div>Ящик (выбранный способ упаковки предполагает перекладывание товара из нашей тары в вашу)</div>
<div>Наличные</div>
<div>{{$order['address']}} {{$order['appart']}} {{($order['porch'] != '') ? 'п. ' . $order['porch'] : ''}}</div>
<div>{{$order['name']}}</div>
<div>{{$order['phone']}} </div>
<div>{{$order['confirm'] == 1 ? 'По звонку оператора' : 'Без звонка оператора'}} </div>

<table  style="border: 1px solid gray;width: 100%; margin: 20px 0 0 0;" >
  <thead style="font-weight: 600;">
    <tr>
      <td>Товар</td>
      <td>Кличество</td>
      <td>Цена</td>
    </tr>
  </thead>
  <tbody>
    @foreach ($order['items'] as $item)
      <tr>
        <td>{{$item['name']}}</td>
        <td>{{$item['quantity']}}</td>
        <td>{{$item['price_final']}}</td>
      </tr>
    @endforeach
    {{-- Subtotal --}}
    <tr>
      <td></td>
      <td style="font-weight:600">Подытог:</td>
      <td>{{$order['items_total']}}</td>
    </tr>
    {{-- Shipping --}}
    <tr>
      <td></td>
      <td style="font-weight:600">Доставка:</td>
      <td>{{$order['shipping']}}</td>
    </tr>
    {{-- Bonus --}}
    @if ($order['bonus'] != 0)
      <tr>
        <td></td>
        <td style="font-weight:600">Бонусы:</td>
        <td>{{$order['bonus']}}</td>
      </tr>
    @endif
    {{-- Coupon --}}
    @if (isset($order['coupons']) && isset($order['coupons'][0]))
      <tr>
        <td></td>
        <td style="font-weight:600">{{$order['coupons'][0]['code']}}:</td>
        <td>-{{intval($order['coupons'][0]['discount'])}}</td>
      </tr>
    @endif
    {{-- total --}}
    <tr>
      <td></td>
      <td style="font-weight:600">Всего:</td>
      <td style="font-weight:600">{{$order['total']}}</td>
    </tr>
  </tbody>

</table>
<div style="font-size: 8pt;">
  <span style="color:red; ">*</span> 
  Обращаем ваше внимание на то, что вес заказа является ориентировочным. По некоторым позициям возможен небольшой недовес/перевес (финальная накладная будет соответственно скорректирована). Мы не разрезаем плоды, поэтому у таких позиций как тыква, капусты, ананасы и проч. вес может отличаться от заданного на 500 гр-1 кг.
</div>

<div style="margin: 20px 0;">
  Если вы нашли ошибку в данных заказа, пожалуйста, сообщите нам об этом любым удобным вам способом. <br>
  Сделаем все, чтобы от души порадовать вас нашими "вкусняшками".
</div>



@endsection
