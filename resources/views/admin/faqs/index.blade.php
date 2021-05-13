@php
    $route = 'faqs';
    $filters = ['category' => $faqs_categories, 'search' => true, 'initial_date' =>true, 'final_date'=>true]; 
    $order = ['fecha de creación' => 't_faqs.created_at', 'nombre' => 't_faqs.title', 'categoría' => 't_faqs_categories.name'];
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($faqs)
        <table id="table-container">
            <div class="title">@lang('admin/faqs.parent_section')</div>
            <tr>
                <th> @lang('admin/faqs.faq-category')</th>
                <th> Visible </th>
                <th> </th>
            </tr>

            @foreach($faqs as $faq_element)
                <tr>
                    <td> {{$faq_element->category->name}}</td>
                    <td>{{$faq_element->visible}}</td>
                    <td>
                        <svg class="edit-button button" data-url="{{route('faqs_show', ['faq' => $faq_element->id])}}" style="width:24px;height:24px" viewBox="0 0 24 24" >
                            <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12H20A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4V2M18.78,3C18.61,3 18.43,3.07 18.3,3.2L17.08,4.41L19.58,6.91L20.8,5.7C21.06,5.44 21.06,5 20.8,4.75L19.25,3.2C19.12,3.07 18.95,3 18.78,3M16.37,5.12L9,12.5V15H11.5L18.87,7.62L16.37,5.12Z" />
                        </svg>
                        <svg class="delete-button button" data-url="{{route('faqs_destroy', ['faq' => $faq_element->id])}}"style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M16,10V17A1,1 0 0,1 15,18H9A1,1 0 0,1 8,17V10H16M13.5,6L14.5,7H17V9H7V7H9.5L10.5,6H13.5Z" />
                        </svg>
                    </td>
                </tr>
            @endforeach

        </table>

        @if($agent->isDesktop())
        @include('admin.layout.table_pagination', ['items' => $faqs])
        @endif

    @endif

    
@endsection

@section('form')

    @isset($faq)

    {{-- @include('admin.layout.errors') --}}


        <div class="form-content">

            <form class="admin-form" id="faqs-form" action="{{route("faqs_store")}}" autocomplete="off">

                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($faq->id) ? $faq->id : ''}}">

                <div class="form-row">
                    <div class="button-create" id="button-create" data-url="{{route("faqs_create")}}">
                        <svg style="width:36px;height:36px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M10,4L12,6H20A2,2 0 0,1 22,8V18A2,2 0 0,1 20,20H4C2.89,20 2,19.1 2,18V6C2,4.89 2.89,4 4,4H10M15,9V12H12V14H15V17H17V14H20V12H17V9H15Z" />
                        </svg>
                    </div>
                    <div class="visible">
                        <label class="switch">
                            <input type="checkbox" name="visible" checked="checked" value="{{ isset($faq->visible) ? $faq->visible : '1' }}"  class="input" id="switch">
                            <span class="slider round"></span>
                        </label>                      
                    </div>
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
                
                <div class="tab-panel tab-active" data-tab="content">
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
                                    @foreach($faqs_categories as $faq_category)
                                        <option value="{{$faq_category->id}}" {{$faq->category_id == $faq_category->id ? 'selected':''}} class="category_id">{{ $faq_category->name }}</option>
                                    @endforeach
                                </select>                   
                            </div>
                        </div>
            
                        <div class="form-group">
                            <div class="form-label">
                                <label for="name" class="label-highlight">Nombre</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="name" value="{{isset($faq->name) ? $faq->name : ''}}"  class="input-highlight"  />
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
                                            <input type="text" name="locale[title.{{$localization->alias}}]" value="{{isset($locale["title.$localization->alias"]) ? $locale["title.$localization->alias"] : ''}}" class="input-highlight">
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

                </div>


            </form>

            <div class="form_submit">
                <button id="send">@lang('admin/faqs.faq-send')</button>
            </div>
                
        </div>

    @endif

@endsection
