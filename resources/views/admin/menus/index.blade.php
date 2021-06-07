@php
    $route = 'menus';
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($menus)

        <div id="table-container">
            @foreach($menus as $menu_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field"><p><span>Nombre:</span> {{$menu_element->name}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('menus_edit', ['menu' => $menu_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                        
                        <div class="table-icons delete-button left-swipe" data-url="{{route('menus_destroy', ['menu' => $menu_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @include('admin.layout.table_pagination', ['items' => $menus])

    @endisset

@endsection

@section('form')

    @isset($menu)

        <div class="form-container">
            <form class="admin-form" id="menus-form" action="{{route("menus_store")}}" autocomplete="off">
                
                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($menu->id) ? $menu->id : ''}}">

                <div class="tabs-container">
                    <div class="tabs-container-menu">
                        <ul>
                            <li class="tab-item tab-active" data-tab="content">
                                Contenido
                            </li>      
                        </ul>
                    </div>
                    
                    <div class="form-buttons">
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
                </div>
                
                <div class="tab-panel tab-active" data-tab="content">
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="name" class="label-highlight">Nombre</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="name" value="{{isset($menu->name) ? $menu->name : ''}}"  class="input-highlight"  />
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            @isset($menu->name)
                <div id="menu-item-form-container">
                    @include('admin.menu_items.index', ['menu' => $menu])
                </div>
            @endisset
            
            <div class="form-submit">
                <button class="send">@lang('admin/faqs.faq-send')</button>
            </div>
                
        </div>

        </div>

    @endisset

@endsection