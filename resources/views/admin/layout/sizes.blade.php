<form class="admin-form" id="size-form" action=""  data-form="sizes" autocomplete="off">
    <input type="hidden" name="id" value="{{isset($size->id) ? $size->id : ''}}">
    <div class="check-box-list">
        <div class="form-group">
            <div class="form-label">
                <label for="sizes" class="label-highlight">Tallas disponibles</label>
            </div>
            <div class="form-input">
                @foreach($size as $size_element)
                    <input type="checkbox" name="size[name.{{$size_element->id}}]" class="checkbox" value="{{$size_element->id}}" class="size">
                    <label for="{{ $size_element->size }}">{{ $size_element->size }}</label><br>
                @endforeach
            </div>
        </div>
    </div>

</form>

<div class="form-submit">
    <div class="send"  data-form="sizes" data-url="{{route("size_store")}}">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19M17,12L12,7V10H8V14H12V17L17,12Z" />
        </svg>
    </div>
</div>
