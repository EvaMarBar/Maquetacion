@extends('front.layout.master')

@section('title')@lang('front/seo.web-name') | {{$shirt->seo->title}} @stop
@section('description'){{$shirt->seo->description != null? $shirt->seo->description : $shirt->seo->locale_seo->description}} @stop
@section('keywords'){{$shirt->seo->keywords != null ? $shirt->seo->keywords : $shirt->seo->locale_seo->keywords}} @stop
@section('facebook-url'){{URL::asset('/shirts/' . $shirt->seo->slug)}} @stop
@section('facebook-title'){{$shirt->seo->title}} @stop
@section('facebook-description'){{$shirt->seo->description != null ? $shirt->seo->description : $shirt->seo->locale_seo->description}} @stop

@section("content")
    @if($agent->isDesktop())
        <div class="page-section">
            @include("front.pages.shirts.desktop.shirt")
        </div>
    @endif

    @if($agent->isMobile())
        <div class="page-section">
            @include("front.pages.shirts.mobile.shirt")
        </div>
    @endif
@endsection
        
        