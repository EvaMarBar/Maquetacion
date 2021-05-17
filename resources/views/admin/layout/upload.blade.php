@if($type == "image" )
    <div class="upload single">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})"></div>
            @endif
        @endforeach

        <span class="upload-prompt"></span>
        <input class="upload-input" type="file" name="image[{{$content}}.{{$alias}}]">
    </div>
@endif
@if($type == "images" )
<div class="upload-multiple" id="upload-multiple">
    <div class="upload-view" id="upload-view">
        <div class="upload group">  
            @component('admin.layout.image_details')    
                @foreach ($files as $image)
                    @if($image->language == $alias)
                        <div class="upload-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})">
                        </div>
                        
                    @endif           
                @endforeach
            @endcomponent

            <span class="upload-prompt"></span>
            <input class="upload-input" type="file" name="images[{{$content}}.{{$alias}}]" value="{{isset($image["title.$localization->alias"]) ? $image["title.$image->alias"] : ''}}">
        
        </div>
        <div class="see-more" data-image="">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="#cccccc" d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7.14,4.5 2.78,7.5 1,12C3.39,18.08 10.25,21.06 16.33,18.67C19.38,17.47 21.8,15.06 23,12C21.22,7.5 16.86,4.5 12,4.5M7,22H9V24H7V22M11,22H13V24H11V22M15,22H17V24H15V22Z" />
            </svg>
        </div>
    </div>
</div>

@endif

