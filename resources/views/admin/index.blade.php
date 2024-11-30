@extends('layouts.layout')

@section('content')
@foreach ($posts as $post)
<div class="card post-card" style="width: 18rem;">
    <img src="{{ $post->image ? asset("img/{$post->image}") :  asset("img/no-photo.jpg")}}" class="card-img-top w-25" alt="...">
    <div class="card-body">
      <h5 class="card-title">{{ $post->title }}</h5>
      <i class="btn btn-sm btn-primary rounded-pill">{{$post->category->name}}</i>
      <p class="card-text">{{ $post->description }}</p>
      <button data-id="{{$post->id}}" type="button" class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#edit">
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
        <h1 class="modal-title fs-5" id="exampleModalLabel">Изменить пост</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="d-inline-block form-edit" action="{{route('admin.edit', $post->id)}}" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Decription</label>
            <input type="text" class="form-control" id="description" name="description" value="">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <div class="row align-items-center">
              {{-- <img src="{{ $post->image ? asset("img/{$post->image}") :  asset("img/no-photo.jpg")}}" class="card-img-top w-25 d-inline-block col-1" alt="..."> --}}
              <input type="file" class="form-control h-25 col-11 w-auto" id="image" name="image">
            </div>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label" id="category" name="category">Category</label>
            <select class="form-select" aria-label="Default select example">
{{--  --}}
            </select>
          </div>
        </div>

        <div class="modal-footer">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
    </div>
  </div>
</div>
@endsection