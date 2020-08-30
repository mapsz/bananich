@extends('layouts.app')

@section('content')

  <site-header></site-header>

  <main>
    <div class="container my-3" style="max-width: 600px">
      <ul class="modal-tabs">
        <li class="modal-tabs-item"><a href="/login">Вход</a></li>
        <li class="modal-tabs-item active"><a href="/signup">Регистрация</a></li>
      </ul>

      <div class="modal-tab-pane active">
        <form class="modal-form" method="POST" action="{{ route('register') }}">
          @csrf
          <div class="modal-form-group">
            <input placeholder="Имя*" id="name" type="text" class="modal-form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="modal-form-group">
            <input placeholder="Фамилия*" id="surname" type="text" class="modal-form-input @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname">
            @error('surname')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="modal-form-group">
            <input placeholder="Телефон*" id="phone" type="text" class="modal-form-input @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
            @error('phone')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="modal-form-group">
            <input placeholder="E-mail*" id="name" type="email" class="modal-form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="modal-form-group">
            <input placeholder="Пароль*" id="password" type="password" class="modal-form-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="modal-form-group">
            <input placeholder="Повторите пароль*" id="password-confirm" type="password" class="modal-form-input" name="password_confirmation" required autocomplete="new-password">
          </div>
          <div class="modal-form-group">
            <input placeholder="Телефон кто порекомендовал нас" id="referral" type="text" class="modal-form-input @error('referral') is-invalid @enderror" name="referral" value="{{ old('referral') }}" autocomplete="referral">
            @error('referral')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="modal-form-btn">
            <button type="submit" class="btn btn-thick">Зарегистрироваться</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <site-footer />

@endsection
