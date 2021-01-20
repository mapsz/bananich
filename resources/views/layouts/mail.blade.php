<?php
$s = new App\Setting;
$number = (isset($site) && $site == 'x') ? $s->byName('x_phone_number') : $s->byName('phone_number');
$color = (isset($site) && $site == 'x') ? '#8ac2a7' : '#FBD610';
?>

<!-- Mail -->
<div 
  style='
    position: relative;
    width:100%;
    margin: auto
  '
>      
  <!-- Header -->
    <div style="
        width: 600px;
        height: 160px;
        margin: auto;
        background: {{$color}};
      "
    >
    <table>
      <tbody>
        <tr>
          <td width="50"></td>
          <td width="450">
            <span style="
              font-family: Arial;
              font-style: normal;
              font-size: 30px;
              line-height: 100%;
              color: #000000;
            ">
              <div align="left">
              @if(isset($site) && $site == 'x')
                <span><b>Neolavka</b></span><br>
                <span>Доставка полезного</span>  
              @else
                <span><b>Бананыч</b></span><br>
                <span>Доставка полезного</span> 
              @endif
              </div>
            </span>
          </td>
          @if(isset($site) && $site == 'x')
            <td align="right" valign="middle" width="160" height='155' ></td>
          @else
            <td align="right" valign="middle" width="160" height='155' 
              style="
                background: url('http://bananich.ru/mail/banana.png');
                background-repeat: round;        
              "
            ></td>
          @endif
        </tr>
      </tbody>
    </table>
  </div>
  
  <!-- Content -->
  <div style='
    box-sizing: border-box;
    width: 600px;
    margin: auto;
    border: 1px {{$color}} solid;
    border-top: 0px;  
    border-bottom: 0px;  
    padding: 10px;
    font-family: Arial;
  '>
    <div style="
        margin: 10px;
        padding: 20px 0px;
        border: 1px solid #828282;
        border-left: 0px;
        border-right: 0px;
      "
    >

      @yield('content')

    </div>
  </div>

  <!-- Footer -->
  <div style="
      box-sizing: border-box;
      width: 600px;
      margin: auto;
      border: 1px {{$color}} solid;
      border-top: 0px;  
      padding: 10px;
    "
  >        
    <table>
      <tbody>
        <tr>
          {{-- Logo --}}          
          @if(isset($site) && $site == 'x')
          <td width="80" height="80" ></td>
          @else            
            <td width="80" height="80" 
              style="
                background: url('https://bananich.ru/mail/logo.png');
                background-repeat: no-repeat;    
                background-position: center;
              "
            ></td>
          @endif  
          {{-- Text --}}
          <td width="250">
            <p>
              <b>
                Пишите или звоните, <br>
                мы всегда рады общению!
              </b>
            </p>
            <p>
              @if(isset($site) && $site == 'x')
                Ваша Neolavka 
              @else
                Ваш Бананыч
              @endif              
            </p>              
          </td>
          <td width="150">
            @if($numner) <span>📞 <a href="#" style="color:black"><b>{{$numner}}</b></a></span> @endif                
          </td>
          {{-- Socs / Link --}}
          <td>
            <table>
              <tr>
                <td width="30" height="25">
                  <!-- <a width="46" height="25" href="https://instagram.com/bananich.ru" target="_blank" >
                    <table><tr><td width="35" height="25" style="
                        background: url('http://bananich.ru/mail/insta.png');
                        background-repeat: no-repeat;        
                    ">                          
                    </td></tr></table>                      
                  </a> -->
                </td>
                <td>
                  <!-- <a width="20" height="25" href="https://vk.com/bananichru" target="_blank" >
                    <table><tr><td width="35" height="25" style="
                        background: url('http://bananich.ru/mail/vk.png');
                        background-repeat: no-repeat;        
                    ">                          
                    </td></tr></table>                      
                  </a> -->
                </td>
              </tr>
              <tr>
                <td colspan="2">                   
                  @if(isset($site) && $site == 'x')
                  <a href="https://neolavka.ru" style="color:black">neolavka.ru</a>
                  @else
                    <a href="https://bananich.ru" style="color:black">bananich.ru</a>
                  @endif                  
                </td>
              </tr>
            </table>
          </td>
        </tr>
        {{-- Unsubscribe --}}
        <tr >
          <td colspan="3" width="600" align="center">
            <a href="https://bananich.ru/unsubscribe" style="color:black">Отписаться</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>