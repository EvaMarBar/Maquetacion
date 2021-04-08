<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       

        <title>Maquetacion</title>
        
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
   
        