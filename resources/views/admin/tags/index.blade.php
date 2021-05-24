{{-- @php
    $route = 'faqs';
    $filters = ['category' => $faqs_categories, 'search' => true, 'initial_date' =>true, 'final_date'=>true]; 
    $order = ['fecha de creación' => 't_faqs.created_at', 'nombre' => 't_faqs.title', 'categoría' => 't_faqs_categories.name'];
@endphp --}}

@extends('admin.layout.table_form')

@section('table')

    @isset($tags)

        <div class="table-container" id="table-container">
            <div class="row-title">
                <div class="title">Tags</div>
            </div>
            <div class="row-header">
                <div class="column">Grupo</div>
                <div class="column">Clave</div>
                <div class="column">Valor</div>
                <div class="column"></div>
            </div> 
                @foreach($tags as $tag)
                    <div class="table-row swipe-element">
                        <div class="table-field-container swipe-front">
                            <div class="table-field column">{{$tag->group}}</div>
                            <div class="table-field column">{{$tag->key}}</div>
                            <div class="table-field column">{{$tag->value}}</div>
                        </div>
                        <div class="table-icons-container swipe-back column">
                            <div class="table-icons edit-button right-swipe" data-url="{{route('taqs_show', ['group' => str_replace('/', '-' , $tag->group), 'key' => $tag->key])}}">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                </svg>
                            </div> 
                        </div>
                    </div>
            @endforeach
        </div>

    @endif
@include('admin.layout.table_pagination', ['items' => $tags])

@endsection

@section('form')

    @isset($tag)

    {{-- @include('admin.layout.errors') --}}


        <div class="form-content">

            <form class="admin-form" id="tags-form" action="{{route("tags_store")}}" autocomplete="off">

                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="group" value="{{$tag->group}}">
                <input type="hidden" name="key" value="{{$tag->key}}">
                
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
                            <div id="import-tags" data-url="{{route('tags_import')}}">
                               Importar
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="group" class="label-highlight">Grupo: {{$tag->group}}</label>
                        </div>
                    </div>
                </div>

                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="key" class="label-highlight">Clave: {{$tag->key}}</label>
                        </div>
                    </div>
                </div>

                @component('admin.layout.locale', ['tab' => 'content'])

                    @foreach ($localizations as $localization)

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

                       
                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="value" class="label-highlight">Valor</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="tag[value.{{$localization->alias}}]" value="{{isset($tag["value.$localization->alias"]) ? $tag["value.$localization->alias"] : ''}}" class="input-highlight">
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
