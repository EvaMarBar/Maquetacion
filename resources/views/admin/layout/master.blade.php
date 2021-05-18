<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
        <title>Maquetacion</title>
        
        @include("admin.layout.partials.style") 

    </head>

    <body>

            @include('admin.layout.messages')
            @include('admin.layout.modal_image')
            @include('admin.layout.spinner')
            @include('admin.layout.sidebar')

            @if($agent->isMobile())
                @include('admin.layout.pop_up')
            @endif
          
            @if(isset($filters))
            @include('admin.layout.table_filters', [
                'route' => $route, 
                'filters' => $filters, 
                'order' => $order
            ])
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
        