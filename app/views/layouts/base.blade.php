<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title', 'Cram')
    </title>
    <meta name="description" content="">
    @section('styles')
        {{ HTML::script('js/vendor.js'); }}
        {{ HTML::script('js/cram.js'); }}
    @show
    @section('scripts')
        {{ HTML::style('css/style.css'); }}
    @show
</head>
<body data-page="{{ Route::currentRouteName() }}">
@yield('content')
</body>
</html>