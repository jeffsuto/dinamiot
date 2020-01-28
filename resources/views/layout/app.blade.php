<!DOCTYPE html>
<html lang="en">
<head>
    @include('assets.styles')
    @include('assets.meta')
    <title>Devices Monitoring</title>
</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">
    @include('partials.header')
    @include('partials.sidebar')
    @include('partials.content')
    {{-- @include('partials.footer') --}}
    @include('assets.js')
    @yield('script')
</body>
</html>