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

            {{-- @include('admin.layout.pop_up') --}}

            @if(isset($filters))
                @include('admin.layout.table_filters', $filters)
            @endif


            <div class="main">
                 @yield('content')
            </div>

            @if($agent->isMobile())
                @include('admin.layout.partials.bottombar')
            @endif

        @include("admin.layout.partials.js")

    </div>

    </body>  
</html>
        