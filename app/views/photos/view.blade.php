@extends('layouts.default')
@section('page')
<h2>
    {{{ $photo->title }}}
</h2>
<h3>
    By {{{ $photo->getUser->firstname . ' ' . $photo->getUser->lastname }}}
</h3>
<img src="{{ URL::route('photo/raw', ['id' => $photo->id]) }}" />
@if($photo->caption)
<p class="caption">
    {{{ $photo->caption }}}
</p>
@else
<p class="caption empty">
    There is no caption for this photo.
</p>
@endif

@if($photo->getUser->id == Auth::id())
<a href="{{ URL::route('photo/delete', ['id' => $photo->id]) }}" class="photo_item-delete">
    Delete Photo
</a>
@endif

@if($photo->getComments->count())
<ul>
@foreach ($photo->getComments as $comment)
    <li>
        <blockquote>
        {{{ $comment->text }}}
        </blockquote>
        <cite>
        {{{ $comment->getUser->firstname }}}
        {{{ $comment->getUser->lastname }}}
        </cite>
    </li>
@endforeach
</ul>
@else
<p>
    This photo has no comments.
</p>
@endif

@if($commentError)
<p>
    {{$commentError}}
</p>
@endif

{{ Form::open(['url' => URL::route('photo/comment', ['id' => $photo->id]), 'class' => 'comment-form']) }}
{{ Form::label('comment-text', 'Comment') }}
{{ Form::textarea('text', '', ['id'=>'comment-text']) }}
{{ Form::hidden('id', $photo->id) }}
{{ Form::submit('Cramsplain') }}
{{ Form::close() }}

@stop