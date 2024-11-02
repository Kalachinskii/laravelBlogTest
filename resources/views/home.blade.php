@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    @foreach ($posts as $post)

        <div class="card" style="width: 18rem;" data-id="{{$post->category->id}}">
            <img src="
            {{$post->image ? asset("img/{$post->image}") : asset("img/no-image.avif")}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$post->title}}</h5>
                <i class="btn btn-sm btn-outline-secondary rounded-pill">{{$post->category->name}}</i>
                <p class="card-text">{{$post->description}}</p>
                <a href="#" class="btn btn-primary stretched-link">Читать далее</a>
                <a href="#" class="btn btn-outline-info">Добавить в избранное</a>
            </div>
        </div>
    @endforeach




@endsection