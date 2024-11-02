@extends('layouts.user.auth')

@section('title', 'Login')

@section('errors-form')
                    {{-- ошибки --}}
    @if ($errors->any())
        <ul class="bg-danger">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
@endsection

@section('login-error')
                    {{-- ошибки --}}
    @if (session('login-error'))
        <ul class="bg-danger">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
@endsection

@section('content')
    <form class="w-50 mx-auto" method="POST" action="{{route('user.checkLogin')}}">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почтовый адресс</label>
            <input value="{{old('email')}}" type="email"  name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>

        <button type="submit" class="btn btn-primary">Авторизация</button>
    
    </form>




@endsection