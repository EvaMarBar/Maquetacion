<div class="faq">

    <div class="faq-title">
        <h3>{{isset($faq->seo->title) ? $faq->seo->title : ""}}</h3>
    </div>
    
    <div class="faq">
        <div class="faq-description">
            <div class="faq-description-text">
                {!!isset($faq->locale['description']) ? $faq->locale['description'] : "" !!}
            </div>

            @isset($faq->image_featured_desktop->path)
                <div class="faq-description-image">
                    <img src="{{Storage::url($faq->image_featured_desktop->path)}}" alt="{{$faq->image_featured_desktop->alt}}" title="{{$faq->image_featured_desktop->title}}" />
                </div>
            @endif
            @isset($faq->image_grid_desktop)
                <div class="faq-description-image-grid">
                    @foreach ($faq->image_grid_desktop as $image)
                        <div class="faq-description-image-grid-item">
                            <img src="{{Storage::url($image->path)}}" alt="{{$image->alt}}" title="{{$image->title}}" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
</div>
