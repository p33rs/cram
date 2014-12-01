@extends('layouts.default')
@section('page')

{{ Form::open(['route' => 'photo/upload', 'class' => 'upload-form', 'files' => true]) }}
<dl>
    <dt>{{ Form::label('upload-photo', 'Photo') }}</dt>
    <dd>{{ Form::file('photo', '', ['id'=>'upload-photo']) }}</dd>
    <dd class="error_text" data-for="photo"></dd>
    <dt>{{ Form::label('upload-title', 'Title') }}</dt>
    <dd>{{ Form::text('title', '', ['id'=>'upload-title']) }}</dd>
    <dd class="error_text" data-for="title"></dd>
    <dt>{{ Form::label('upload-caption', 'Caption') }}</dt>
    <dd>{{ Form::textarea('caption', '', ['id'=>'upload-caption']) }}</dd>
    <dd class="error_text" data-for="caption"></dd>
</dl>
{{ Form::submit('Cram This') }}
{{ Form::close() }}

@stop