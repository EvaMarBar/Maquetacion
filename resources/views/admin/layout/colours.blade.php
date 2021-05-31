<form class="admin-form" id="colour-form" action=""  data-form="colours" autocomplete="off">
    <input type="hidden" name="id" value="{{isset($colour->id) ? $colour->id : ''}}">
    <div class="check-box-list">
        <div class="form-group">
            <div class="form-label">
                <label for="colours" class="label-highlight">Colores disponibles</label>
            </div>
            <div class="form-input">
                @foreach($colour as $colour_element)
                    <input type="checkbox" name="colour[name.{{$colour_element->id}}]" value="{{$colour_element->id}}" class="colour">
                    <label for="{{$colour_element->colour}}">{{$colour_element->colour}}</label><br>
                @endforeach
            </div>
        </div>
    </div>
</form>

<div class="form-submit">
    <div class="send"  data-form="colours" data-url="{{route("colour_store")}}">
        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19M17,12L12,7V10H8V14H12V17L17,12Z" />
        </svg>
    </div>
</div>