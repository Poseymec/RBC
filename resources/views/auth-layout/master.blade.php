<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>@yield('titre')</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="{{asset('authFrontend/css/roboto-font.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('authFrontend/fonts/font-awesome-5/css/fontawesome-all.min.css')}}">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="{{asset('authFrontend/css/style.css')}}"/>
</head>

@include('auth-layout.header')

{{--  debut contenu--}}

    @yield('contenu')


{{--  fin  contenu--}}
@include('auth-layout.footer')