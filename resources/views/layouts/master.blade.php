<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @section('header')
        @include('layouts.header')
    @show
</head>
<body class="@yield('body_class')">

@yield('content')

@section('footer')
    @include('layouts.footer')
@show
</body>
</html>
