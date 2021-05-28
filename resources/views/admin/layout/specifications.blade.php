<form class="admin-form" id="specifications-form" action="{{route("specification_store")}}" autocomplete="off">
    <input type="hidden" name="id" value="{{isset($specifications->id) ? $specifications->id : ''}}">

    <div>
        <div class="two-columns">
            <div class="form-group">
                <div class="form-label">
                    <label for="product_number" class="label-highlight">Nº de Producto</label>
                </div>
                <div class="form-input">
                    <input type="text" name="product_number"  value="{{isset($specification->product_number) ? $specification->product_number : ''}}" class="input-highlight">
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="designer" class="label-highlight">Diseñador</label>
                </div>
                <div class="form-input">
                    <input type="text" name="designer"  value="{{isset($specification->designer) ? $specification->designer : ''}}" class="input-highlight">
                </div>
            </div>
        </div>
    </div>

    @component('admin.layout.locale', ['tab' => 'specifications'])

    @foreach ($localizations as $localization)

        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

            <div class="one-column">
                <div class="form-group">
                    <div class="form-label">
                        <label for="material" class="label-highlight">Material</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="locale[material.{{$localization->alias}}]" value='{{isset($locale["material.$localization->alias"]) ? $locale["material.$localization->alias"] : ''}}' class="input-highlight">
                    </div>
                </div>
            </div>

        
        </div>

    @endforeach
    @endcomponent

</form>
<div class="form-submit">
    <div class="send">Especificaciones</div>
</div>

