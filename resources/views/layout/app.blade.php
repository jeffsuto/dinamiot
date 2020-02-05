<!DOCTYPE html>
<html lang="en">
<head>
    @include('assets.styles')
    @include('assets.meta')
    <title>Dinamiot | IoT Devices Monitoring</title>
</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns fixed-navbar bg-blue-grey bg-darken-3">
    @include('partials.header')
    @include('partials.sidebar')
    @include('partials.content')
    {{-- @include('partials.footer') --}}
    @include('assets.js')
    @stack('script')
</body>
</html>