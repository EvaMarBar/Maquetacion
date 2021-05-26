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
            <div class="description-text">{!!isset($faq_element->locale['description']) ? $faq_element->locale['description'] : "" !!}</div>
            @isset($faq_element->image_featured_desktop->path)
                <div class="description-image">
                    <img src="{{Storage::url($faq_element->image_featured_desktop->path)}}" alt="{{$faq_element->image_featured_desktop->alt}}" title="{{$faq_element->image_featured_desktop->title}}" />
                </div>
            @endif
            @isset($faq_element->image_grid_desktop)
                    <div class="description-image-collection">
                        @foreach ($faq_element->image_grid_desktop as $image)
                            <img src="{{Storage::url($image->path alt="{{$image->alt}}" title="{{$image->title}}")}}"/> 
                        @endforeach
                    </div>
            @endif
        </div>

  
    </div>
    
    @endforeach

</div>

@endsection
