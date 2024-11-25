@extends('layouts.layout')

@section('content')
@foreach ($posts as $post)
<div class="card" style="width: 18rem;">
    <img src="{{ $post->image ? asset("img/{$post->image}") :  asset("img/no-photo.jpg")}}" class="card-img-top w-25" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{ $post->title }}</h5>
      <i class="btn btn-sm btn-primary rounded-pill">{{$post->category->name}}</i>
      <p class="card-text">{{ $post->description }}</p>
      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit">
        Edit
      </button>
      <form class="d-inline-block" action="{{route('admin.destroy', $post->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Del</button>
      </form>
    </div>
  </div>
@endforeach

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <form class="d-inline-block" action="{{route('admin.edit', $post->id)}}" method="post">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection