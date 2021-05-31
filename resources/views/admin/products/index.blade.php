@php
$route = 'product';
@endphp

@extends('admin.layout.table_form')

@section('table')

@isset($products)

    <div class="table-container" id="table-container">
        <div class="row-title">
            <div class="title">Productos</div>
        </div>
        <div class="row-header">
            <div class="column">Nº Producto</div>
            <div class="column">Precio</div>
            <div class="column"></div>
        </div> 
            @foreach($products as $product_element)
                <div class="table-row swipe-element">
                    {{-- <div class="table-field-container swipe-front">
                        <div class="table-field column">{{$product_element->specifications->product_number}}</div>
                    </div> --}}
                    <div class="table-field-container swipe-front">
                        <div class="table-field column">{{$product_element->price}}</div>
                    </div>
                    <div class="table-icons-container swipe-back column">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('products_show', ['product' => $product_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                    </div>
                </div>
        @endforeach
    </div>

@endif

{{-- @include('admin.layout.table_pagination', ['items' => $prducts]) --}}

@endsection


@section('form')

    @isset($product)

        <div class="form-content">
        

            <form class="admin-form" id="products-form" action="{{route("specification_store")}}" autocomplete="off">

                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($product->id) ? $product->id : ''}}">

                <div class="form-buttons">
                    <div class="button-create" id="button-create" data-url="">
                        <svg style="width:36px;height:36px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M10,4L12,6H20A2,2 0 0,1 22,8V18A2,2 0 0,1 20,20H4C2.89,20 2,19.1 2,18V6C2,4.89 2.89,4 4,4H10M15,9V12H12V14H15V17H17V14H20V12H17V9H15Z" />
                        </svg>
                    </div>
                    <div class="visible">
                        <label class="switch">
                            <input type="checkbox" name="visible" checked="checked" value="{{ isset($product->visible) ? $product->visible : '1' }}"  c+lass="input" id="switch">
                            <span class="slider round"></span>
                        </label>                      
                    </div>
                </div>
                <div class="tabs-container">
                    <div class="tabs-container-menu">
                        <ul>
                            <li class="tab-item tab-active" data-tab="specifications">
                                Características
                            </li>     
                            <li class="tab-item" data-tab="content">
                                Contenido
                            </li>   
                            <li class="tab-item" data-tab="sizes">
                                Tallas
                            </li>    
                            <li class="tab-item" data-tab="colours">
                                Colores
                            </li>    
                            <li class="tab-item" data-tab="images">
                                Imágenes
                            </li>
                            <li class="tab-item" data-tab="seo">
                                Seo
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-panel  tab-active" data-tab="specifications">
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
                </div>
                
                <div class="tab-panel" data-tab="content">

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
                                        <option name="product[category_id]" value="{{$shirt_category->id}}" {{$product->category_id == $shirt_category->id ? 'selected':''}} class="category_id">{{ $shirt_category->name }}</option>
                                    @endforeach
                                </select>                   
                            </div>
                        </div>
            
                        <div class="form-group">
                            <div class="form-label">
                                <label for="name" class="label-highlight">Nombre</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="name" value="{{isset($product->name) ? $product->name : ''}}"  class="input-highlight"  />
                            </div>
                        </div>
                    </div>

                    <div class="two-columns">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="original_price" class="label-highlight">Precio inicial</label>
                            </div>
                            <div class="form-input">
                                
                                <input type="text" name="product[original_price]" value="{{isset($product->original_price) ? $product->original_price : ''}}"  class="input-highlight">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label">
                                <label for="taxes" class="label-highlight">Impuestos</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="product[taxes]" value="{{isset($product->taxes) ? $product->taxes : ''}}" class="input-highlight">
                            </div>
                        </div>
                    </div>

                    <div class="two-columns">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="discount" class="label-highlight">Descuento</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="prodcut[discount]" value="{{isset($product->discount) ? $product->discount : ''}}" class="input-highlight">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label">
                                <label for="price" class="label-highlight">Precio</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="product[price]" value="{{isset($product->price) ? $product->price : ''}}" class="input-highlight">
                            </div>
                        </div>
                    </div>

                    @component('admin.layout.locale', ['tab' => 'content'])

                        @foreach ($localizations as $localization)

                            <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

                                <div class="one-column">
                                    <div class="form-group">
                                        <div class="form-label">
                                            <label for="name" class="label-highlight">Título</label>
                                        </div>
                                        <div class="form-input">
                                            <input type="text" name="seo[title.{{$localization->alias}}]" value="{{isset($seo["title.$localization->alias"]) ? $seo["title.$localization->alias"] : ''}}" class="input-highlight">
                                        </div>
                                    </div>
                                </div>

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
                
                    @endcomponent
                </div>

                <div class="tab-panel" data-tab="sizes">
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

                </div>

                <div class="tab-panel" data-tab="colours">

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

                </div>
                                
                <div class="tab-panel" data-tab="images">

                    @component('admin.layout.locale', ['tab' => 'images'])

                        @foreach ($localizations as $localization)

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="images" data-localetab="{{$localization->alias}}">

                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Foto destacada</label>
                                    </div>
                                    <div class="form-input">
                                        @include('admin.layout.upload', [
                                            'entity' => 'products',
                                            'type' => 'single', 
                                            'content' => 'featured', 
                                            'alias' => $localization->alias,
                                            'files' => $product->images_featured_preview
                                        ])
                                    </div>
                                </div>
                            </div>

                        </div>

                        @endforeach

                        @foreach ($localizations as $localization)

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="images" data-localetab="{{$localization->alias}}">

                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Fotos Múltiples</label>
                                    </div>
                                    <div class="form-input">
                                        @include('admin.layout.upload', [
                                            'entity' => 'products',
                                            'type' => 'collection', 
                                            'content' => 'grid', 
                                            'alias' => $localization->alias,
                                            'files' => $product->images_grid_preview
                                        ])
                                    </div>
                                </div>
                            </div>

                        </div>

                        @endforeach
                
                    @endcomponent
                </div>

                <div class="tab-panel" data-tab="seo">

                    @component('admin.layout.locale', ['tab' => 'seo'])

                        @foreach ($localizations as $localization)

                            <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="seo" data-localetab="{{$localization->alias}}">

                                <div class="one-column">
                                    <div class="form-group">
                                        <div class="form-label">
                                            <label for="keywords" class="label-highlight">
                                                Keywords 
                                            </label>
                                        </div>
                                        <div class="form-input">
                                            <input type="text" name="seo[keywords.{{$localization->alias}}]" value='{{isset($seo["keywords.$localization->alias"]) ? $seo["keywords.$localization->alias"] : ''}}' class="input-highlight">
                                        </div>
                                    </div>
                                </div>

                                <div class="one-column">
                                    <div class="form-group">
                                        <div class="form-label">
                                            <label for="description" class="label-highlight">
                                                Descripción. 
                                            </label>
                                        </div>

                                        <div class="form-input">
                                            <textarea maxlength='160' class="input-highlight input-counter" name="seo[description.{{$localization->alias}}]">{{isset($seo["description.$localization->alias"]) ? $seo["description.$localization->alias"] : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                                                
                            </div>

                        @endforeach
                
                    @endcomponent

                </div>


            </form>

            <div class="form-submit">
                <div class="send">@lang('admin/faqs.faq-send')</div>
            </div>
                        
        </div>

    @endif

@endsection