@extends('layouts.user.auth')

@section('title', 'Home')

@section('content')
<form class="w-50 mx-auto" method="POST" action="{{route('user.store')}}">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Почтовый адресс</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Проверка паролья</label>
        <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword1">
    </div>

    <button type="submit" class="btn btn-primary">Регистрация</button>
</form>




@endsection