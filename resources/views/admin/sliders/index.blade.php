@php
    $route = 'sliders';
    $filters = ['search' => true, 'initial_date' =>true, 'final_date'=>true]; 
    $order = ['fecha de creación' => 't_sliders.created_at', 'nombre' => 't_sliders.name', 'entity' => 't_sliders.entity'];

@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($sliders)

        <div class="table-container" id="table-container">
            <div class="row-title">
                <div class="title">Sliders</div>
            </div>
            <div class="row-header">
                <div class="column">Nombre</div>
                <div class="column">Entidad</div>
                <div class="column">Visible</div>
                <div class="column"></div>
            </div> 
                @foreach($sliders as $slider_element)
                    <div class="table-row swipe-element">
                        <div class="table-field-container swipe-front">
                            <div class="table-field column">{{$slider_element->name}}</div>
                            <div class="table-field column">{{$slider_element->entity}}</div>
                            <div class="table-field column">{{$slider_element->visible}}</div>
                        </div>
                        <div class="table-icons-container swipe-back column">
                            <div class="table-icons edit-button right-swipe" data-url="{{route('sliders_show', ['slider' => $slider_element->id])}}">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                </svg>
                            </div> 
                            
                            <div class="table-icons delete-button left-swipe" data-url="{{route('sliders_destroy', ['slider' => $slider_element->id])}}">
                                <svg viewBox="0 0 24 24">
                                    <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
    
    @include('admin.layout.table_pagination', ['items' => $sliders])

    @endif
@endsection

@section('form')

    @isset($slider)

    {{-- @include('admin.layout.errors') --}}


        <div class="form-content">

            <form class="admin-form" id="sliders-form" action="{{route("sliders_store")}}" autocomplete="off">

                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($slider->id) ? $slider->id : ''}}">

                <div class="form-row">
                   
                </div>
                <div class="tabs-container">
                    <div class="tabs-container-menu">
                        <ul>
                            <li class="tab-item tab-active" data-tab="content">
                                Contenido
                            </li>      
                            <li class="tab-item" data-tab="images">
                                Imágenes
                            </li>
                        </ul>
                    </div>
                </div>
                
                @component('admin.layout.locale', ['tab' => 'content'])

                @foreach ($localizations as $localization)

                    <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

                        <div class="one-column">
                            <div class="form-group">
                                <div class="form-label">
                                    <label for="name" class="label-highlight">Nombre</label>
                                </div>
                                <div class="form-input">
                                    <input type="text" name="locale[name.{{$localization->alias}}]" value="{{isset($locale["name.$localization->alias"]) ? $locale["name.$localization->alias"] : ''}}" class="input-highlight">
                                </div>
                            </div>
                        </div>

                        <div class="one-column">
                            <div class="form-group">
                                <div class="form-label">
                                    <label for="entity" class="label-highlight">Entidad</label>
                                </div>
                                <div class="form-input">
                                    <input type="text" name="locale[entity.{{$localization->alias}}]" value="{{isset($locale["entity.$localization->alias"]) ? $locale["entity.$localization->alias"] : ''}}" class="input-highlight">
                                </div>
                            </div>
                        </div>

                    </div>

                @endforeach
        
            @endcomponent
{{-- 
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
                                @include('admin.components.upload', [
                                    'type' => 'image', 
                                    'content' => 'featured', 
                                    'alias' => $localization->alias,
                                    'files' => $faq->images_featured
                                ])
                            </div>
                        </div>
                    </div>

                </div>

                @endforeach
        
            @endcomponent

        </div> --}}


            </form>

            <div class="form-buttons">
                <button id="send">Enviar</button>
                <div class="button-create" id="button-create" data-url="{{route("sliders_create")}}">
                    <svg style="width:36px;height:36px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M10,4L12,6H20A2,2 0 0,1 22,8V18A2,2 0 0,1 20,20H4C2.89,20 2,19.1 2,18V6C2,4.89 2.89,4 4,4H10M15,9V12H12V14H15V17H17V14H20V12H17V9H15Z" />
                    </svg>
                </div>
                <div class="visible" id="switch">
                    <label class="switch">
                        <input type="checkbox" name="visible" checked="checked" value="{{$slider->visible == 1 ? 'true' : 'false'}}" {{$slider->visible == 1 ? 'checked' : '' }}  class="input" id="switch">
                        <span class="slider round"></span>
                    </label>                      
                </div>
            </div>
                
        </div>

    @endif

@endsection
