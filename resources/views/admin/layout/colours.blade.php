<form class="admin-form" id="colour-form" action="" autocomplete="off">
    <div class="check-box-list">
        <div class="form-group">
            <div class="form-label">
                <label for="colours" class="label-highlight">Colores disponibles</label>
            </div>
            <div class="form-input">
                @foreach($colour as $colour_element)
                    <input type="checkbox" value="{{$colour_element->id}}" class="colour">
                    <label for="{{$colour_element->colour}}">{{$colour_element->colour}}</label><br>
                @endforeach
            </div>
        </div>
    </div>
</form>

<div class="form-submit">
    <div class="send">Colores</div>
</div>