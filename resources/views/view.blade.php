@extends('layout')

@section('content')
<div class="row">
    <div class="coll">
        <a href="{{ route('adView', ['id' => $ad->id ]) }}">
            <p>{{ $ad->title }}</p>
            <p>{{ $ad->description }}</p>
            <p>{{ $ad->price }}</p>
            <p>{{ $ad->user->name }}</p>
        </a>
        <a class="btn btn-danger" href="{{ route('adDelete', ['id' => $ad->id ]) }}">Delete</a>
        <a class="btn btn-success" href="">Update</a>
        <hr>
    </div>
</div>
@endsection
