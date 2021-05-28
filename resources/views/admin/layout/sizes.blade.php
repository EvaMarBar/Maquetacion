<form class="admin-form" id="size-form" action="" autocomplete="off">

    <div class="check-box-list">
        <div class="form-group">
            <div class="form-label">
                <label for="sizes" class="label-highlight">Tallas disponibles</label>
            </div>
            <div class="form-input">
                @foreach($size as $size_element)
                    <input type="checkbox" value="{{$size_element->id}}" class="size">
                    <label for="{{ $size_element->size }}">{{ $size_element->size }}</label><br>
                @endforeach
            </div>
        </div>
    </div>

</form>

<div class="form-submit">
    <div class="send">Talla</div>
</div>
