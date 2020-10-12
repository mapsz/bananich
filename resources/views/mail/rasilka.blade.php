@extends('layouts.mail')

@section('content')

<div style="font-family: arial;  font-size: 16pt;">

    <h3 align="center">
      {{$user['name']}}, здравствуйте!
    </h3>    

    <p align="center" style="width:450px; margin:auto">
      Бананыч решил проводить новые акции каждую неделю, чтобы вы смогли покупать любимые овощи и фрукты по самым низким ценам. 
    </p>

    <hr>

    <p>
      На этой неделе в витаминной программе:
    </p>

    <ul>
      <li>хит и новинка сезона хурма Свечка за 120₽ вместо 200₽ (сочная, не вяжет, мы ее ооооочень ждали!)</li>
      <li>азербайджанские гранаты за 120₽ вместо 200₽ (обязательны к потреблению в период вирусной турбулентности!!!)</li>
      <li>маленькие хрустящие огурчики за 50₽ вместо 80₽</li>
      <li>помидоры Азербайджанские за 140₽ вместо 270₽😍 (мясистые и ароматные)</li>
      <li>цветная капуста за 120₽ вместо 160₽ за килограмм.</li>

    </ul>

    <p>
      Уточнение❗️ Цены указываются за 1 кг, если Вы хотите заказать 2 кг, то цена за второй кг будет учитываться уже без скидки🤓
    </p>  

    <p>
      Крепкого вам здоровья и приятных покупок на Бананыче!
    </p>

    <table>
      <tbody>
        {{-- Line --}}
        <tr>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/14560.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
          <td width="30"></td>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/1923.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
          <td width="30"></td>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/1739.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
        </tr>
        <tr>
          <td>            
            <div><b>Хурма свечка</b><div>
            <div>500 грамм<div>
            <span style="text-decoration: line-through;">100руб</span> 
            <span style="color: rgb(255, 92, 0);"><b>60руб</b></span> 
            <div align="center">
              <a href="https://bananich.ru/product/14560" style="text-decoration: none;">
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
          <td>            
            <div><b>Гранат премиум</b><div>
              <div>Азербайджан, 500г<div>
              <span style="text-decoration: line-through;">100руб</span> 
              <span style="color: rgb(255, 92, 0);"><b>60руб</b></span> 
            <br>
            <div align="center">
              <a href="https://bananich.ru/product/1923" style="text-decoration: none;">
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
          <td>            
            <div><b>Огурцы Короткоплодные</b><div>
            <div>Беларусь, 500г<div>
            <span style="text-decoration: line-through;">40руб</span> 
            <span style="color: rgb(255, 92, 0);"><b>25руб</b></span> 
            <div align="center">
              <a href="https://bananich.ru/product/1739" style="text-decoration: none;">
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
        </tr>
        {{-- padding --}}
        <tr height='30'></tr>
        {{-- Line --}}
        <tr>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/3766.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
          <td width="30"></td>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/2139.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
        </tr>
        <tr>
          <td>            
            <div><b>Aзербайджанские помидоры</b><div>
            <div>Азербайджан, 500г<div>
            <span style="text-decoration: line-through;">135р</span> 
            <span style="color: rgb(255, 92, 0);"><b>70р</b></span> 
            <div align="center">
              <a href="https://bananich.ru/product/3766" style="text-decoration: none;">
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
          <td>            
            <div><b>Цветная капуста</b><div>
              <div>Россия, 1кг<div>
              <span style="text-decoration: line-through;">160руб</span> 
              <span style="color: rgb(255, 92, 0);"><b>120руб</b></span> 
            <br>
            <div align="center">
              <a href="https://bananich.ru/product/2139" style="text-decoration: none;">
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
        </tr>
      </tbody>
    </table>

</div>



@endsection

