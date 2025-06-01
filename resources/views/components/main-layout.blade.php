<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('/logo/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>
        SIMPONI
    </title>
    @env('APP_ENV', 'local')
        @vite(['resources/css/app.css'])
    @else
        <link rel="stylesheet" href="{{ asset('assets/app.css') }}"/>
    @endenv
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    @livewireStyles
</head>

<body x-data="{
    'loaded': true,
    'darkMode': $persist(false).as('darkMode'),
    'stickyMenu': false,
    'sidebarToggle': false,
    'scrollTop': false
    }" 
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark': darkMode }">

    {{ $slot }}

    @livewireScripts
</body>

</html>
