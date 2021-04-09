<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title>Maquetacion</title>
        
        @include("admin.layout.partials.style") 

    </head>

    <body>
            @include('admin.layout.sidebar')

            <div class="main">
                 @yield('content')
            </div>
        

        @include("admin.layout.partials.js")

    </div>

    </body>  
</html>
        