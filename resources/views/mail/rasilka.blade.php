@extends('layouts.mail')

@section('content')

<div style="font-family: arial;  font-size: 16pt;">

    <h3 align="center">
      {{$user['name']}}, добрый день!
    </h3>    

    <p align="center" style="width:450px; margin:auto">
      Бананыч приготовил для вас классную осеннюю акцию! До конца недели у нас специальные цены на самые горячие хиты сезона. Успейте оформить заказ и побаловать себя нашими вкусняшками!
    </p>

    <hr>

    <p>
      В нашей витаминной программе:
    </p>

    <ul>
      <li>очень сладкая, совсем не вяжущая хурма Королек</li>
      <li>сочный и насыщенный виноград Молдова</li>
      <li>настоящая детская радость виноград Кишмиш (детей от него не оторвать)</li>
      <li>сочная фейхоа, для любителей экзотики и варенья😊</li>
      <li>ну и крутейший овощной микс: баклажаны, кабачки и цветная капуста.</li>
    </ul>

    <p>
      Все свежайшее, приедет к вам прямиком с утреннего привоза овощных баз Петербурга. Заказывайте скорее!
    </p>  

    <table>
      <tbody>
        {{-- Line --}}
        <tr>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/2139.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
          <td width="30"></td>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/6892.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
          <td width="30"></td>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/7521.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
        </tr>
        <tr>
          <td>            
            <div><b>Цветная капуста</b><div>
            <div>Россия, 1кг<div>
            <span style="text-decoration: line-through;">100руб</span> 
            <span style="color: rgb(255, 92, 0);"><b>80руб</b></span> 
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
          <td width="30"></td>
          <td>            
            <div><b>Кабачки</b><div>
              <div>Россия, 500г<div>
              <span style="text-decoration: line-through;">40руб</span> 
              <span style="color: rgb(255, 92, 0);"><b>20руб</b></span> 
            <br>
            <div align="center">
              <a href="https://bananich.ru/product/6892" style="text-decoration: none;">
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
            <div><b>Баклажаны</b><div>
            <div>Россия, 500г<div>
            <span style="text-decoration: line-through;">60руб</span> 
            <span style="color: rgb(255, 92, 0);"><b>30руб</b></span> 
            <div align="center">
              <a href="https://bananich.ru/product/7521" style="text-decoration: none;">
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
            background: url('https://bananich.ru/products/images/main/14540.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
          <td width="30"></td>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/14557.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
          <td width="30"></td>
          <td width="160" height="160" style="
            background: url('https://bananich.ru/products/images/main/14543.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
        </tr>
        <tr>
          <td>            
            <div><b>Хурма Королек</b><div>
            <div>Узбекистан, 500г<div>
            <span style="text-decoration: line-through;">80р</span> 
            <span style="color: rgb(255, 92, 0);"><b>40р</b></span> 
            <div align="center">
              <a href="https://bananich.ru/product/14540" style="text-decoration: none;">
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
            <div><b>Фейхоа</b><div>
              <div>Греция, 500г<div>
              <span style="text-decoration: line-through;">170руб</span> 
              <span style="color: rgb(255, 92, 0);"><b>100руб</b></span> 
            <br>
            <div align="center">
              <a href="https://bananich.ru/product/14557" style="text-decoration: none;">
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
            <div><b>Виноград Кишмиш</b><div>
            <div>Турция, 500г<div>
            <span style="text-decoration: line-through;">80руб</span> 
            <span style="color: rgb(255, 92, 0);"><b>40руб</b></span> 
            <div align="center">
              <a href="https://bananich.ru/product/14543" style="text-decoration: none;">
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
            background: url('https://bananich.ru/products/images/main/10094.jpg');
            background-repeat: no-repeat;        
          ">
          </td>
        </tr>
        <tr>
          <td>            
            <div><b>Виноград Молдова</b><div>
            <div>Молдова, 500г<div>
            <span style="text-decoration: line-through;">80р</span> 
            <span style="color: rgb(255, 92, 0);"><b>40р</b></span> 
            <div align="center">
              <a href="https://bananich.ru/product/10094" style="text-decoration: none;">
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

