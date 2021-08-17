@extends('layout')

@section('content')
<div class="row">
    <div class="col">
    @auth
        <h2>Name</h2> <hr>
        <p> {{ $user->name }} </p>
        <h2>Email</h2> <hr>
        <p> {{ $user->email }} </p>
        <a class="btn btn-success" href="{{ route('adCreateForm') }}">Create Ads</a>
    @endauth
    </div>
</div>
@endsection
