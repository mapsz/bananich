@extends('layouts.app')

@section('content')

<juge-main>

    <div class="container my-5" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="border:0px">

                    <div class="m-4">
                        Для запроса смены пароля, пожалуйста, введите e-mail, на который был зарегистрирован ваш аккаунт
                    </div>                

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Ваш e-mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" style="background-color: rgb(138 194 167);;color: black;">
                                        Отправьте мне ссылку на смену пароля
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</juge-main>



@endsection
