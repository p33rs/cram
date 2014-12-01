@extends('layouts.base')

@section('content')
<h1>
    <a href="{{ URL::to('/') }}">
        cram
    </a>
</h1>
<nav>
    <ul>
        <li>
            <a href="{{ URL::route('photos') }}">Photos</a>
        </li>
        <li>
            <a href="{{ URL::route('photos/new') }}">Discover</a>
        </li>
        <li>
            <a href="{{ URL::route('user/photos', ['id' => Auth::id()]) }}">Me</a>
        </li>
        <li>
            <a href="{{ URL::route('account') }}">Account</a>
        </li>
        <li>
            <a href="{{ URL::route('photo/upload') }}">Upload</a>
        </li>
    </ul>
</nav>
<div class="content">
    @yield('page')
</div>
@stop