@extends('layouts.default')
@section('page')
@if($photos)
<ul class="photo_list">
    @foreach($photos as $photo)
    <li class="photo_list-item photo_item" data-id="{{ $photo->id }}">
        <h3 class="photo_item-title">{{{ $photo->title }}}</h3>
        <h4>{{{ $photo->getUser->firstname . ' ' . $photo->getUser->lastname }}}</h4>
        <img src="{{ URL::route('photo/raw', ['id' => $photo->id]) }}" />
        <p>
            {{{ $photo->caption }}}
        </p>
        <a href="{{ URL::route('photo', ['id' => $photo->id]) }}">View Comments</a>
        @if($photo->getUser->id == Auth::id())
        <a href="{{ URL::route('photo/delete', ['id' => $photo->id]) }}" class="photo_item-delete">
            Delete Photo
        </a>
        @endif
    </li>
    @endforeach
</ul>
@else
<p>would you kindly CRAM MORE PHOTOS</p>
@endif
@stop