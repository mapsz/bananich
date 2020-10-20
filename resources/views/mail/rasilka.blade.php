@extends('layouts.mail')

@section('content')

<div style="font-family: arial;  font-size: 16pt;">

    <h3 align="center">
      {{$user['name']}}, добрый день!
    </h3>    

    <p align="center" style="width:450px; margin:auto">
      Уже 3-ю неделю подряд мы устраиваем акции на разные товары из нашего ассортимента😌 И останавливаться не намерены😄
    </p>

    <p align="center">
      Сегодня у нас «Дегустационный сет»😋
    </p>
    
    <hr>

    <p>
      На этой неделе размер скидок составляет от 33 до 60%! 
    </p>  

    <p>
      По новым ценам вы можете приобрести:
    </p>  

    <p>
      👉 просто наивкуснейшую хурму Ромашку за 40₽;<br>
      👉 сладчайший с шоколадной мякотью Королёк 40₽;<br>
      👉 крупного размера спелый киви за 50₽;<br>
      👉 сочные яблоки Голден за 40₽;<br>
      👉 хрустящие яблоки Антоновка за 40₽;<br>
      👉 самый диетический сельдерей  за 50₽;<br>
      👉 грейпфрут, который не горчит и можно есть без сахара за 50₽.
    </p> 

    <p>
      И настоящий цельнозерновой хлеб по 100 г, как раз на пробу, всего по 15₽ вместо 30!
    </p>

    <p>
      👉 ржаной;<br>
      👉 пшеничный;<br>
      👉 десертный с изюмом😋<br>
    </p>     



    <table>
      <tbody>
        {{-- Line --}}
        @foreach ($products as $k => $line)
          {{-- Image --}}
          <tr>
            @foreach ($line as $j => $product)
              <td width="160" height="160" style="
                background: url('https://bananich.ru/products/images/main/<?=$product["id"]?>.jpg');
                background-repeat: no-repeat;        
              "></td>
              <td width="30"></td>
            @endforeach
          </tr>
          {{-- data --}}
          <tr>
            @foreach ($line as $j => $product)
              <td>
                <div><b>{{$product["name"]}}</b><div>
                <div>{{$product["unit"]}}<div>
                <span style="text-decoration: line-through;">{{$product["price"]}}руб</span> 
                <span style="color: rgb(255, 92, 0);"><b>{{$product["discount"]}}руб</b></span> 
                <div align="center">
                  <a href="https://bananich.ru/product/<?=$product["id"]?>" style="text-decoration: none;">
                    <p align="center" style="
                      width: 120px;
                      margin: auto;
                      margin-top: 20px;
                      background-color: #fbe214;
                      padding: 15px;
                      border-radius: 30px;
                      color:black;
                    ">
                      Купить
                    </p>                
                  </a>
                </div>            
              </td>
              <td width="30"></td>
            @endforeach
          </tr>
          {{-- Padding --}}
          <tr height='30'></tr>

          

        @endforeach


      </tbody>
    </table>


    <p>
      Не упустите шанс попробовать что-то новенькое и немного сэкономить🤪
    </p>    

</div>



@endsection

