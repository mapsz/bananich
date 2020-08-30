@extends('layouts.app')

@section('content')
  <site-header></site-header>
  
  <main>
    <login p-show="signup"></login>
  </main>

  <site-footer />

@endsection
