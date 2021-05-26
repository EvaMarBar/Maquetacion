<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
       
		<title>@yield('title', trans('front/seo.title'))</title>
		<meta name="description" content="@yield('description', trans('front/seo.description'))">
        <meta name="keywords" 	 content="@yield('keywords', trans('front/seo.keywords'))">
        <link rel=”canonical” href=”https://dev-maquetacion.com”>

		<meta property="fb:app_id"        content="" /> 
		<meta property="og:url"           content="@yield('facebook-url', 'https://dev-maquetacion.com')" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="@yield('facebook-title',  trans('front/seo.title'))"/>
		<meta property="og:description"   content="@yield('facebook-description', trans('front/seo.description'))" />

        
        @include("front.layout.partials.style") 

    </head>

    <body>
        <header>
            <h1>
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z" />
                </svg>
                Cabecera
            </h1>
        </header>

        <div class="main">
            @yield('content')
        </div>

        @include("front.layout.partials.js")
   
        