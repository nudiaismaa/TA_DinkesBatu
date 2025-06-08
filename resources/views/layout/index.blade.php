<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/just-logo.svg') }}">
    @include('include.style')
    @yield('style')
</head>

<body>
    <div id="app">
        @include('include.sidebar')
        <div id="main" class="main-content">
            @include('include.header')
            <div class="content mx-2 my-3">
                @yield('content')
            </div>
        </div>
    </div>
    @include('include.script');
    @yield('script')

</body>

</html>
