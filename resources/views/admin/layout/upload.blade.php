@if($type == "image" )
    <div class="upload single">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})"></div>
            @endif
        @endforeach

        <span class="upload-prompt">@lang('admin/upload.image')</span>
        <input class="upload-input" type="file" name="images[{{$content}}.{{$alias}}]">
    </div>
@endif
@if($type == "images" )
    <div class="upload collection">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})"></div>
            @endif
        @endforeach

        <div id="more-upload">
            <span class="upload-prompt">@lang('admin/upload.image')</span>
            <input class="upload-input" type="file" name="images[{{$content}}.{{$alias}}]">
        </div>
             
        </div>
    </div>
@endif

