@extends('layout')

@section('content')
<div class="row">
    <div class="coll">
        <form enctype="multipart/form-data" action="{{ $route ?? route('adCreate') }}" method="post">
            @csrf
            <div class="form-group">
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="exampleFormControlInput1">Title</label>
                <input type="text"  name="title" value="{{ $title ?? '' }}" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
            <div class="form-group">
                @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="exampleFormControlTextarea1">Price</label>
                <input type="text"  name="price" value="{{ $price ?? '' }}" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
            <div class="form-group">
                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="exampleFormControlInput1">Description</label>
                <textarea class="form-control"  name="description" id="exampleFormControlTextarea1" rows="3">
                    {{ $description ?? '' }}"
                </textarea>
            </div>
            <div class="mt-3">
                 <button class="btn btn-success"> {{ $button ?? 'Create' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
