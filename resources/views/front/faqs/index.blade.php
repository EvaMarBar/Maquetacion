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
            <p>{!!isset($faq_element->locale['description']) ? $faq_element->locale['description'] : "" !!}</p>
            @isset($faq_element->image_featured_desktop->path)
                <div class="description-image">
                    <img src="{{Storage::url($faq_element->image_featured_desktop->path)}}" alt="{{$faq_element->image_featured_desktop->alt}}" title="{{$faq_element->image_featured_desktop->title}}" />
                </div>
            @endif
        </div>

  
    </div>
    
    @endforeach

</div>

@endsection
