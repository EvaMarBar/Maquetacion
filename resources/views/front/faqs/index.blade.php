@extends('front.layout.table_form')

@section('table')

<div class="faqs">

    <div class="title-faqs">
        <h3>Preguntas Frecuentes</h3>
    </div>

    @foreach($faqs as $faq_element)

    <div class="faq">
        <div class="title" id="{{$faq_element->id}}"> {{$faq_element->title}} 
            <svg class="button" id="{{$faq_element->id}}" style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20 14H14V20H10V14H4V10H10V4H14V10H20V14Z" />
            </svg>
        </div>

        <div class="description" id="{{$faq_element->id}}">
            {{$faq_element->description}}
        </div>
    </div>
    
    @endforeach

</div>

@endsection
