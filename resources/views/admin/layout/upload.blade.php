@if($type == "image" )
    @foreach ($files as $image)
        @if($image->language == $alias)
            <div class="upload-image single {{$image->id}}" data-url="{{route('show_image_seo', ['image' => $image->id])}}">
                
                <div class="upload-image-options">
                    <svg viewBox="0 0 24 24">
                        <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" />
                    </svg>
                </div>

                <div class="upload-image-thumb" style="background-image: url({{Storage::url($image->path)}})"></div>
            </div>
        @endif
    @endforeach

    <div class="upload-image-add single">
        <span class="upload-image-prompt">@lang('admin/image.image-drop')</span>
        <input class="upload-image-input" type="file" name="images[{{$content}}.{{$alias}}]">
    </div>
@endif

@if($type == "images")

    <div class="upload-image-collection">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-image collection {{$image->id}}" data-url="{{route('show_image_seo', ['image' => $image->id])}}">
                    <div class="upload-image-options">
                        <svg viewBox="0 0 24 24">
                            <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" />
                        </svg>
                    </div>
           
                    <div class="upload-image-thumb" style="background-image: url({{Storage::url($image->path)}})"></div>
                </div>
            @endif
        @endforeach

        <div class="upload-image-add collection" data-content="{{$content}}" data-alias="{{$alias}}">      
            <span class="upload-image-prompt">+</span>
            <input class="upload-image-input" type="file">
            <div class="see-more" data-image="">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="#cccccc" d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7.14,4.5 2.78,7.5 1,12C3.39,18.08 10.25,21.06 16.33,18.67C19.38,17.47 21.8,15.06 23,12C21.22,7.5 16.86,4.5 12,4.5M7,22H9V24H7V22M11,22H13V24H11V22M15,22H17V24H15V22Z" />
                </svg>
            </div>
        </div>
    </div>

@endif