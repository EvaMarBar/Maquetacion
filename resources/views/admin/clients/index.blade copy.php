@extends('admin.layout.table_form')

@section('table')

    <table>
        <div class="title">@lang('admin/clients.parent_section')</div>
        <tr>
            <th>@lang('admin/clients.client_order_id')</th>
            <th>@lang('admin/clients.client_email')</th>
            {{-- <th>@lang('admin/clients.client_country')</th>
            <th>@lang('admin/clients.client_date_ordered')</th>
            <th>@lang('admin/clients.client_date_sended')</th>
            <th>@lang('admin/clients.client_payment')</th> --}}
            {{-- <th> </th> --}}
        </tr>

        <div class="swipe-element">
            <div class="swipe-back">
            </div>
            <div class="swipe-front promote-layer">
                @foreach($clients as $client_element)
                    <tr>
                        <td> {{$client_element->order_id}} </td>
                        <td> {{$client_element->email}} </td>
                        {{-- <td> {{$client_element->country->name}} </td>
                        <td> {{$client_element->date_ordered}} </td>
                        <td> {{$client_element->date_sended}} </td>
                        <td> {{$client_element->payment}} </td> --}}
                    </tr>
                @endforeach
            </div>
        </div>
    </table>
   
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
