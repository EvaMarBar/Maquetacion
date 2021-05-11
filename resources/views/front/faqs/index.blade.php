@extends('front.layout.master')

@section('content')

<div class="faqs">

    <div class="title-faqs">
        <h3>Preguntas Frecuentes</h3>
    </div>

    @foreach($faqs as $faq_element)

    <div class="faq">
        <div class="title" id="{{$faq_element->id}}"> {{isset($faq_element->locale['title']) ? $faq_element->locale['title'] : ""}}
            <div class="plusminus button" id="{{$faq_element->id}}">
            </div>
        </div>

        <div class="description" id="{{$faq_element->id}}">
            {!!isset($faq_element->locale['description']) ? $faq_element->locale['description'] : "" !!}
        </div>
    </div>
    
    @endforeach

</div>

@endsection
