@extends('layouts.mail')

@section('content')


{{-- в данных отдельно примененный прромокод выведи плиз, коммент, реферала, спсоб оплаты и упаковки, остальное по данным норм. ТЕкст вот так правим: --}}

<?php $c = '₽'?>

<div>
  <h2 align="center">Здравствуйте!</h2>
</div>

<div><b>
  Спасибо, что оформили заказ на  @if($site == 'x') Neolavka. @else Бананыче. @endif
</b></div>
<div style="text-align: justify;">Он уже в работе и будет доставлен в выбранное вами время. В день доставки в вашем личном кабинете появится информация о более точном времени прибытия курьера и его контактный номер для связи.</div>
<br>
<br>

{{-- Order details --}}
<div style="width:400px; margin:auto;">
  {{-- Title --}}
  <h3 align="center">Информация по заказу:</h3>

  {{-- Order data --}}
  <div>
    {{-- ID --}}
    <div>Заказ №<b>{{$order['id']}}</b></div>
    {{-- Date / Time --}}
    <div>
      <span><b>      
        {{-- Date --}}      
        <?php setlocale(LC_TIME, 'ru_RU.UTF-8');?>
        <span style="text-transform:capitalize">
          {{Carbon\Carbon::parse($order['delivery_date'])->isoFormat('dddd, D MMMM YYYY')}}
        </span>
        |
        {{-- Time --}}
        <span>
          <span>
            с {{str_replace(':', '', str_replace('00','',$order['delivery_time_from']))}}:00
          </span>
          <span>
            до {{str_replace(':', '', str_replace('00','',$order['delivery_time_to']))}}:00
          </span>
        </span>
      </b></span>
    </div>
    {{-- Paymethod --}}
    <div>
      Оплата: 
      <b>
        @switch($order['pay_method'])
          @case('cash')
            Наличные
            @break
      
          @case('cart')
            Картой курьеру
            @break

          @case('transfer')
            По банковским реквизитам
            @break  

          @default
            {{dd($order['pay_method'])}}

        @endswitch            
      </b>
    </div>  
    {{-- Confirm --}}
    <div><b>{{$order['confirm'] == 1 ? 'Подтверждение по телефону' : 'Без звонка оператора'}}</b></div>    
    <hr>
  </div>
  
  {{-- Address \ Contact data --}}
  <div>
    @if(!$order['to_other'])<div>{{$order['address']}} {{$order['appartPorch']}}</div>@endif
    <div>{{$order['name']}}</div>
    <div>{{$order['phone']}} </div>    
  </div>

  {{-- Comment --}}
  @if($order['comment'])
    <div>
      <hr><span>{{$order['comment']}}</span>
    </div>  
  @endif

  {{-- To other --}}
  @if($order['to_other'])
    <hr>
    <div>
      <div><b>Заказ для другого человека:</b></div>
      <div>{{$order['address']}} {{$order['appartPorch']}}</div>
      <div>{{$order['to_other']['name']}}</div>
      <div>{{$order['to_other']['phone']}} </div>    
    </div>
      {{-- Comment --}}
    @if($order['to_other']['comment'])
      <div>
        <hr><span>{{$order['to_other']['comment']}}</span>
      </div>  
    @endif
  @endif
</div>

<br>
<br>

{{-- List --}}
<table  style="width: 100%; margin: 20px 0 0 0;" >
  <thead style="font-weight: 600;">
    <tr>
      <td>Товар</td>
      <td>Количество</td>
      <td>Цена</td>
    </tr>
  </thead>
  <tbody>
    <tr><td colspan="3"><hr></td></tr>
    {{-- Items --}}
    @foreach ($order['items'] as $item)
      <tr>
        <td>{{$item['name']}}</td>
        <td>{{$item['quantity']}}</td>
        <td align="right">{{$item['price_final']}} {{$c}}</td>
      </tr>
    @endforeach
    {{-- Results --}}
    @if('results' == 'results')
      <tr><td colspan="3"><hr></td></tr>
      {{-- Subtotal --}}
      <tr>
        <td></td>
        <td>Подытог:</td>
        <td align="right">{{$order['items_total']}} {{$c}}</td>
      </tr>
      {{-- Shipping --}}
      <tr>
        <td></td>
        <td>Доставка:</td>
        <td align="right">{{$order['shipping']}} {{$c}}</td>
      </tr>
      {{-- Bonus --}}
      @if ($order['bonus'] != 0)
        <tr>
          <td></td>
          <td>Бонусы:</td>
          <td align="right">{{$order['bonus']}} {{$c}}</td>
        </tr>
      @endif
      {{-- Coupon --}}
      @if (isset($order['coupons']) && isset($order['coupons'][0]))
        <tr>
          <td></td>
          <td>{{$order['coupons'][0]['code']}}:</td>
          <td align="right">-{{intval($order['coupons'][0]['discount'])}} {{$c}}</td>
        </tr>
      @endif
      {{-- total --}}
      <tr>
        <td></td>
        <td style="font-weight:600">Всего:</td>
        <td align="right" style="font-weight:600">{{$order['total']}} {{$c}}</td>
      </tr>
    @endif
  </tbody>
</table>

{{-- Tips --}}
<div>
  <hr>
  {{-- Container tip--}}
  @if($order['container'] == 0)
    <div style="font-size: 8pt;">
      <span style="color:red; ">*</span> 
      Выбранный способ упаковки предполагает перекладывание товара из нашей тары в вашу.
    </div>
  @endif
  {{-- Items tip--}}
  <div style="font-size: 8pt;">
    <span style="color:red; ">*</span> 
    Обращаем ваше внимание на то, что вес заказа является ориентировочным. По некоторым позициям возможен небольшой недовес/перевес (финальная накладная будет соответственно скорректирована). Мы не разрезаем плоды, поэтому у таких позиций как тыква, капусты, ананасы и проч. вес может отличаться от заданного на 500 гр-1 кг.
  </div>
  <hr>
  
</div>

{{-- After Text --}}
<div style="margin: 20px 0;">
  <p>Если вы нашли ошибку в данных заказа, пожалуйста, сообщите нам об этом любым удобным вам способом.</p>
  <div style="text-align: center; width:400px; margin:auto;">
    <span style=" font-size:12pt"><b>Сделаем все, чтобы от души порадовать вас нашими "вкусняшками".</b></span>
  </div>
</div>

@endsection
