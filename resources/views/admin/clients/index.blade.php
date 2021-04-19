@extends('admin.layout.table_form')

@section('table')

    <div id="table-container">
        <div class="row row-title">
            <div class="title">@lang('admin/clients.parent_section')</div>
        </div>
        <div class="row row-header">
            <div class="column">@lang('admin/clients.client_order_id')</div>
            <div class="column">@lang('admin/clients.client_email')</div>
        </div> 

        @foreach($clients as $client_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field">{{$client_element->order_id}}</div>
                        <div class="table-field">{{$client_element->email}}</div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('clients_show', ['client' => $client_element->id])}}">
                            <svg class="edit-button button" style="width:24px;height:24px" viewBox="0 0 24 24" >
                                <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12H20A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4V2M18.78,3C18.61,3 18.43,3.07 18.3,3.2L17.08,4.41L19.58,6.91L20.8,5.7C21.06,5.44 21.06,5 20.8,4.75L19.25,3.2C19.12,3.07 18.95,3 18.78,3M16.37,5.12L9,12.5V15H11.5L18.87,7.62L16.37,5.12Z" />
                            </svg>
                        </div> 
                        
                        <div class="table-icons delete-button left-swipe" data-url="{{route('clients_destroy', ['client' => $client_element->id])}}">
                            <svg class="delete-button button" style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M16,10V17A1,1 0 0,1 15,18H9A1,1 0 0,1 8,17V10H16M13.5,6L14.5,7H17V9H7V7H9.5L10.5,6H13.5Z" />
                            </svg>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>

@endsection


@section('form')

    {{-- @include('admin.layout.errors') --}}

   
        <div class="form-content">

            <form class="admin-form" id="client-form" action="{{route("clients_store")}}" autocomplete="off">

                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($client->id) ? $client->id : ''}}">

                <div class="form-topbar" id="form-topbar">
                    <div class="icon" id="icon">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M13,7H11V11H7V13H11V17H13V13H17V11H13V7Z" />
                        </svg>
                    </div>
                    <div class="form-topbar-options" id="form-topbar-options">
                        <ul>
                            <div class="pannel-buttons" data-but="1">
                                <li>Nombre</li>
                            </div>
                            <div class="pannel-buttons" data-but="2">
                                <li>Dirección</li>
                            </div>
                            <div class="pannel-buttons" data-but="3">
                                <li>Contacto</li>
                            </div>
                            <div class="pannel-buttons" data-but="4">
                                <li>Pedidos</li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="pannel-form active" data-num="1">

                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_name')</label>
                        </div>
                        <div class="form_input">
                            <input type="text" name="client_name" value="{{isset($client->client_name) ? $client->client_name : ''}}" class="input">
                        </div>
                    </div>
                    
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_surname')</label>
                        </div>
                        <div class="form_input">
                            <input type="text" name="surname" value="{{isset($client->surname) ? $client->surname : ''}}" class="input">
                        </div>
                    </div>
                </div>

                <div class="pannel-form" data-num="2">    
                    <div class="form_group_column">
                        <div class="form_label" id="address">
                            <label>@lang('admin/clients.client_address')</label>
                        </div>

                        <div class="form_input">
                            <input type="text" name="address" value="{{isset($client->address) ? $client->address : ''}}" class="input">
                        </div>
                    </div>
                    
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_postal_code')</label>
                        </div>

                        <div class="form_input">
                            <input type="text" name="postal_code" value="{{isset($client->postal_code) ? $client->postal_code : ''}}" class="input">
                        </div>
                    </div>
                    
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_city')</label>
                        </div>

                        <div class="form_input">
                            <input type="text" name="city" value="{{isset($client->city) ? $client->city : ''}}" class="input">
                        </div>
                    </div>
                    
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_country')</label>
                        </div>
                        <div class="form_input">
                            <select name="country_id" value="id">
                                <option></option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}" {{$client->country_id == $country->id ? "selected" : ""}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pannel-form" data-num="3">
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_email')</label>
                        </div>

                        <div class="form_input">
                            <input type="text" name="email" value="{{isset($client->email) ? $client->email : ''}}" class="input">
                        </div>
                    </div>

                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_telephone')</label>
                        </div>

                        <div class="form_input">
                            <input type="text" name="telephone" value="{{isset($client->telephone) ? $client->telephone : ''}}" class="input">
                        </div>
                    </div>
                </div>
                
                <div class="pannel-form" data-num="4">
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_order_id')</label>
                        </div>

                        <div class="form_input">
                            <input type="text" name="order_id" value="{{isset($client->order_id) ? $client->order_id : ''}}" class="input">
                        </div>
                    </div>
                    
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_date_ordered')</label>
                        </div>

                        <div class="form_input">
                            <input type="date" name="date_ordered" value="{{isset($client->date_ordered) ? $client->date_ordered : ''}}" class="input">
                        </div>
                    </div>
                    
                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_date_sended')</label>
                        </div>

                        <div class="form_input">
                            <input type="date" name="date_sended" value="{{isset($client->date_sended) ? $client->date_sended : ''}}" class="input">
                        </div>
                    </div>

                    <div class="form_group_column">
                        <div class="form_label">
                            <label>@lang('admin/clients.client_payment')</label>
                        </div>
                        <div class="form_input">
                            <select name="payment" value="{{isset($client->payment) ? $client->payment : ''}}">
                                <option></option>
                                <option  class="input"> @lang('admin/clients.client_payed')</option>
                                <option class="input">@lang('admin/clients.client_pending')</option>
                            </select>
                        </div>
                    </div>
                </div>

            </form>

            <div class="form_submit">
                <button id="send">@lang('admin/clients.client_send')</button>
            </div>
            <div class="form_submit">
                <button id="next">Siguiente</button>
            </div>
                
        </div>


@endsection
