@extends('front.layout.master')

@section("content")
    <div class="welcome">
        @if(Auth::guard('web')->check())
            Hola {{Auth::guard('web')->user()->name}}
        @else
            No estás logueado
        @endif
    </div>
@endsection