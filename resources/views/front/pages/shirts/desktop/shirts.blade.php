<div class="shirts-multiple-title">
        <h2>CAMISETAS</h2>
</div>
<div class="shirts-multiple">
    @foreach ($shirts as $shirt)
        <div class="shirt-multiple" data-content="{{$loop->iteration}}">
            <div class="shirt-multiple-title-container">
                <div class="shirt-title">
                    <h3>{{isset($shirt->seo->title) ? $shirt->seo->title : ""}}</h3>
                </div>
                <div class="shirt-image-featured">
                    @isset($shirt->image_grid_desktop)
                    <div class="shirt-description-image-grid">
                        @foreach ($shirt->image_grid_desktop as $image)
                            <div class="shirt-description-image-grid-item">
                                <img src="{{Storage::url($image->path)}}" alt="{{$image->alt}}" title="{{$image->title}}" />
                            </div>
                        @endforeach
                    </div>
                @endif
                </div>

                {{-- <div class="faq-plus-button plusminus button" data-button="{{$loop->iteration}}"></div> --}}
            </div>
            {{-- <div class="shirt-description">
                <div class="shirt-description-text">
                    {!!isset($shirt->locale['description']) ? $shirt->locale['description'] : "" !!}
                </div>

                <div class="faq-description-image">
                    @isset($faq->image_featured_desktop->path)
                        <div class="faq-description-image-featured">
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
            </div> --}}
        </div>
    @endforeach
    
</div>
