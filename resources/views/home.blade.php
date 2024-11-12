@extends('layouts.layout')

@section('title', 'Home')

@section('register-alert')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
@endsection

@section('content')
    @foreach ($posts as $post)
        <div class="card" style="width: 18rem;" data-id="{{$post->category->id}}">
            <img src="
            {{$post->image ? asset("img/{$post->image}") : asset("img/no-image.avif")}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <i class="btn btn-sm btn-outline-secondary rounded-pill">{{$post->category->name}}</i>
                <p class="card-text">{{$post->description}}</p>
                <a href="#" class="btn btn-primary">Читать далее</a>
                {{-- a - отправляет через GET переделываем на форму --}}
                {{-- <a href="#" class="btn btn-outline-info">Добавить в избранное</a> --}}
                <form class="d-inline-block" action="{{route('post.store')}}" method="post">
                    @csrf;
                    <input type="hidden" name="postId" value="{{$post->id}}">
                    <button type="submit" class="d-inline-block btn btn-outline-info">В избранное</button>
                </form>
            </div>
        </div>
    @endforeach




@endsection