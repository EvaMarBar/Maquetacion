@if($type == "image" )
    <div class="upload single">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})"></div>
            @endif
        @endforeach

        <span class="upload-prompt"></span>
        <input class="upload-input" type="file" name="images[{{$content}}.{{$alias}}]">
    </div>
@endif
@if($type == "images" )
<div class="upload-multiple">
    <div class="upload group">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})">
                </div>
            @endif
        @endforeach

        <span class="upload-prompt"></span>
        <input class="upload-input" type="file" name="images[{{$content}}.{{$alias}}]">
        <div class="upload-delete">
            <svg class="delete-button button" data-url=""style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M16,10V17A1,1 0 0,1 15,18H9A1,1 0 0,1 8,17V10H16M13.5,6L14.5,7H17V9H7V7H9.5L10.5,6H13.5Z" />
            </svg>
        </div>

    </div>
</div>
@endif

