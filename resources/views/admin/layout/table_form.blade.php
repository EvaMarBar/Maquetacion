@extends('admin.layout.master')

@section('content')

{{-- class="two-columns" --}}
    <div>
        <div class="table" id="table">
            @yield('table')
        </div>

        {{-- <div class="form" id="form">
            @yield('form')
        </div>
    </div> --}}

@endsection