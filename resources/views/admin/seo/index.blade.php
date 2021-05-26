@php
    $route = 'seo';
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($seos)

        <div class="table-container" id="table-container">
            <div class="row-title">
                <div class="title">Seo</div>
            </div>
            <div class="row-header">
                <div class="column">Clave</div>
                <div class="column"></div>
            </div> 
                @foreach($seos as $seo_element)
                    <div class="table-row swipe-element">
                        <div class="table-field-container swipe-front">
                            <div class="table-field column">{{$seo_element->key}}</div>
                        </div>
                        <div class="table-icons-container swipe-back column">
                            <div class="table-icons edit-button right-swipe" data-url="{{route('seo_edit', ['key' => $seo_element->key])}}">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                </svg>
                            </div> 
                        </div>
                    </div>
            @endforeach
        </div>

    @endif

    @include('admin.layout.table_pagination', ['items' => $seos])

@endsection

@section('form')

    @isset($seo)

        <div class="form-content">

            <form class="admin-form" id="seos-form" action="{{route('seo_store')}}" autocomplete="off">

                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                
                <div class="tabs-container">
                    <div class="tabs-container-menu">
                        <ul>
                            <li class="tab-item tab-active" data-tab="content">
                                Contenido
                            </li>      
                        </ul>
                    </div>
                </div>
                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <div class="import" id="import-tags" data-url="{{route('seo_import')}}">
                                <span>Importar</span>
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
    
                @component('admin.layout.locale', ['tab' => 'content'])

                    @foreach ($localizations as $localization)

                        <input type="hidden" name="seo[key.{{$localization->alias}}]" value="{{$seo["key.$localization->alias"]}}">
                        <input type="hidden" name="seo[group.{{$localization->alias}}]" value="{{$seo["group.$localization->alias"]}}">
                        <input type="hidden" name="seo[old_url.{{$localization->alias}}]" value="{{isset($seo["url.$localization->alias"]) ? $seo["url.$localization->alias"] : ''}}" class="input-highlight block-parameters-old"  data-regex="/\{.*?\}/g" > 

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">


                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="seo[url.{{$localization->alias}}]">Url</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="seo[url.{{$localization->alias}}]" value="{{isset($seo["url.$localization->alias"]) ? $seo["url.$localization->alias"] : ''}}" class="block-parameters">
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="seo[title.{{$localization->alias}}]" class="label-highlight">Título</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="seo[title.{{$localization->alias}}]" value="{{isset($seo["title.$localization->alias"]) ? $seo["title.$localization->alias"] : ''}}">
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="seo[description.{{$localization->alias}}]" class="label-highlight">Descripción</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="seo[description.{{$localization->alias}}]" value="{{isset($seo["description.$localization->alias"]) ? $seo["description.$localization->alias"] : ''}}" class="input-highlight">
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Keywords</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="seo[keywords.{{$localization->alias}}]" value="{{isset($seo["keywords.$localization->alias"]) ? $seo["keywords.$localization->alias"] : ''}}" class="input-highlight">
                                    </div>
                                </div>
                            </div>

                        </div>

                    @endforeach
        
                @endcomponent
        
            </form>

            <div class="form-submit">
                <button id="send">@lang('admin/faqs.faq-send')</button>
            </div>

        </div>
        @else

        <div class="form-container">
            <div class="tabs-container">
                <div class="tabs-container-menu">
                    <ul>
                        <li class="tab-item tab-active" data-tab="content">
                            Contenido
                        </li>      
                    </ul>
                </div>
            </div>

            <div class="tab-panel tab-active" data-tab="content">
                <div class="three-columns">
                    <div class="form-group">
                        <div class="form-label">
                            <div class="button-seo" id="import-seo" data-url="{{route('seo_import')}}">
                                <span>Importar</span>
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label">
                            <div class="button-seo" id="ping-google" data-url="{{route('ping_google')}}">
                                <span>GoogleBot</span>
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M4,3A1,1 0 0,0 3,4A17,17 0 0,0 20,21A1,1 0 0,0 21,20V16.5A1,1 0 0,0 20,15.5C18.76,15.5 17.55,15.3 16.43,14.93C16.08,14.82 15.69,14.9 15.41,15.18L13.21,17.38C10.38,15.94 8.07,13.62 6.62,10.79L8.82,8.58C9.1,8.31 9.18,7.92 9.07,7.57C8.7,6.45 8.5,5.24 8.5,4A1,1 0 0,0 7.5,3M16,3V6H13V8H16V11H18V8H21V6H18V3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label">
                            <div class="button-seo" id="create-sitemap" data-url="{{route('create_sitemap')}}">
                                <span>Sitemap</span>
                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z" />
                                </svg>
                            </div>
                        </div>
                        <div class="one-column">
                            <div class="form-input seo-imput">
                                <textarea id="sitemap" class="simple"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

@endsection