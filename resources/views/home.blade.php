@extends('layout')

@section('content')
<div class="row">
    <div class="coll">
    @forelse ($ads as $ad)
{{--        <div><img src="/storage/images/ads" alt=""/>{{ $ad->image }}</div>--}}
        <a href="{{ route('adView', ['id' => $ad->id ]) }}">
            <p>{{ $ad->title }}</p>
            <p>{{ $ad->description }}</p>
            <p>{{ $ad->price }}</p>
            <p>{{ $ad->user->name }}</p>
        </a>
        @can('delete', $ad)
        <a class="btn btn-danger" href="{{ route('adDelete', ['id' => $ad->id ]) }}">Delete</a>
        @endcan
        @can('update', $ad)
        <a class="btn btn-success" href="{{ route('adUpdateForm', ['id' => $ad->id ]) }}">Update</a>
        @endcan
        <hr>

    @empty
        <p>No ads</p>
    @endforelse
    {{ $ads->links('bootstrap') }}
    </div>
</div>
@endsection
