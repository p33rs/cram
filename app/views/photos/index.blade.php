@extends('layouts.default')
@section('page')
@if($error = Session::pull('view_error'))
<p>
    {{$error}}
</p>
@endif
@if($photos)
<ul>
    @foreach($photos as $photo)
    <li>
        <img src="{{ URL::route('photo/raw', ['id' => $photo->id]) }}" />
        <p>
            {{ $photo->caption }}
        </p>
        <a href="{{ URL::route('photo', ['id' => $photo->id]) }}">View Comments</a>
    </li>
    @endforeach
</ul>
@else
<p>would you kindly CRAM MORE PHOTOS</p>
@endif
@stop