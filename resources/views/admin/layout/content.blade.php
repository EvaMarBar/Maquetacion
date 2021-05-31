<form class="admin-form" id="content-form" action="{{route("products_store")}}" data-form="content" autocomplete="off">
    <input type="hidden" name="id" id="product_id" value="{{isset($product->id) ? $product->id : ''}}">
    <div class="form-row-panel">
        <div class="form-group">
            <div class="form-label">
                <label for="category_id" class="label-highlight">
                    Categoría 
                </label>
            </div>
            <div class="form-input">
                <select name="category_id" data-placeholder="Seleccione una categoría" class="input-highlight">
                    <option></option>
                    @foreach($shirts_categories as $shirt_category)
                        <option value="{{$shirt_category->id}}" {{$product->category_id == $shirt_category->id ? 'selected':''}} class="category_id">{{ $shirt_category->name }}</option>
                    @endforeach
                </select>                   
            </div>
        </div>

        <div class="form-group">
            <div class="form-label">
                <label for="name" class="label-highlight">Nombre</label>
            </div>
            <div class="form-input">
                <input type="text" name="name" value="{{isset($product->name) ? $product->name : ''}}"  class="input-highlight"/>
            </div>
        </div>
    </div>
    
    <div class="two-columns">
        <div class="form-group">
            <div class="form-label">
                <label for="original_price" class="label-highlight">Precio inicial</label>
            </div>
            <div class="form-input">
                
                <input type="text" name="original_price" value="{{isset($product->original_price) ? $product->original_price : ''}}"  class="input-highlight">
            </div>
        </div>

        <div class="form-group">
            <div class="form-label">
                <label for="taxes" class="label-highlight">Impuestos</label>
            </div>
            <div class="form-input">
                <input type="text" name="taxes" value="{{isset($product->taxes) ? $product->taxes : ''}}" class="input-highlight">
            </div>
        </div>
    </div>

    <div class="two-columns">
        <div class="form-group">
            <div class="form-label">
                <label for="discount" class="label-highlight">Descuento</label>
            </div>
            <div class="form-input">
                <input type="text" name="discount" value="{{isset($product->discount) ? $product->discount : ''}}" class="input-highlight">
            </div>
        </div>
    
        <div class="form-group">
            <div class="form-label">
                <label for="price" class="label-highlight">Precio</label>
            </div>
            <div class="form-input">
                <input type="text" name="price" value="{{isset($product->price) ? $product->price : ''}}" class="input-highlight">
            </div>
        </div>
    </div>

    @component('admin.layout.locale', ['tab' => 'content'])

        @foreach ($localizations as $localization)

            <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="description" class="label-highlight">Descripción</label>
                        </div>
                        <div class="form-input">
                            <textarea class="ckeditor input-highlight" name="locale[description.{{$localization->alias}}]">{{isset($locale["description.$localization->alias"]) ? $locale["description.$localization->alias"] : ''}}</textarea>
                        </div>
                    </div>
                </div>

            </div>


           
        @endforeach
        <div class="form-submit">
            <div class="send" data-url="{{route("products_store")}}" data-form="content">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19M17,12L12,7V10H8V14H12V17L17,12Z" />
                </svg>
            </div>
        </div>

    @endcomponent
</form>