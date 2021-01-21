@extends('layouts.mail')

@section('content')
<?php
$color = (isset($site) && $site == 'x') ? '#8ac2a7' : '#FBD610'
?>

  <div>
    Спасибо, что зарегистрировались на NEO LAVKA. Для того, чтобы завершить процесс регистрации, пожалуйста, «нажмите» на кнопку ниже
  </div>
  
  <br>

  <div style="display: flex;">
    <center>
      <a href="{{$link}}" style="color:black; text-decoration: none; margin: auto; background-color:{{$color}};border: 0;padding: 10px;border-radius: 50px;">
        Зарегистрироваться
      </a>
    </center>
  </div>  

  <br>

  <div>Если не работает, Скопируйте ссылку...</div>
  <div style="font-size:10px;    overflow-wrap: anywhere;">
    {{$link}}
  </div>

@endsection