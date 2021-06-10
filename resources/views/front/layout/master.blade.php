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
        @include("front.layout.partials.topbar")
        @include("front.layout.partials.header_fixed")
        @include("front.layout.modal_localization")
        @include("front.layout.spinner")
   

        @if(isset($filters))
        @include('front.layout.table_filters', [
            'route' => $route, 
            'filters' => $filters, 
            'order' => $order
            ])
        @endif

        <div class="main" id="content">
            @yield('content')
        </div>

        @include("front.layout.partials.footer")
        @include("front.layout.partials.bottombar")
        @include("front.layout.partials.js")
    </body>
   
        