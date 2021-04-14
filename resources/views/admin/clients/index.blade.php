@extends('admin.layout.table_form')

@section('table')

    <table>
        <div class="title">@lang('admin/clients.parent_section')</div>
        <tr>
            <th>@lang('admin/clients.client_order_id')</th>
            <th>@lang('admin/clients.client_email')</th>
            <th>@lang('admin/clients.client_country')</th>
            <th>@lang('admin/clients.client_date_ordered')</th>
            <th>@lang('admin/clients.client_date_sended')</th>
            <th>@lang('admin/clients.client_payment')</th>
            <th> </th>
        </tr>

        @foreach($clients as $client_element)
            <tr>
                <td> {{$client_element->order_id}} </td>
                <td> {{$client_element->email}} </td>
                <td> {{$client_element->country}} </td>
                <td> {{$client_element->date_ordered}} </td>
                <td> {{$client_element->date_sended}} </td>
                <td> {{$client_element->payment}} </td>
                <td>
                    <svg class="edit-button button" data-url="{{route('clients_show', ['client' => $client_element->id])}}" style="width:24px;height:24px" viewBox="0 0 24 24" >
                        <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12H20A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4V2M18.78,3C18.61,3 18.43,3.07 18.3,3.2L17.08,4.41L19.58,6.91L20.8,5.7C21.06,5.44 21.06,5 20.8,4.75L19.25,3.2C19.12,3.07 18.95,3 18.78,3M16.37,5.12L9,12.5V15H11.5L18.87,7.62L16.37,5.12Z" />
                    </svg>
                    <svg class="delete-button button" data-url="{{route('clients_destroy', ['client' => $client_element->id])}}"style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M16,10V17A1,1 0 0,1 15,18H9A1,1 0 0,1 8,17V10H16M13.5,6L14.5,7H17V9H7V7H9.5L10.5,6H13.5Z" />
                    </svg>
                </td>
            </tr>
        @endforeach

    </table>
   
@endsection


@section('form')

    {{-- @include('admin.layout.errors') --}}


        <div class="form-content">

            <form class="admin-form" id="client-form" action="{{route("clients_store")}}" autocomplete="off">

                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($client->id) ? $client->id : ''}}">

                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_name')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="client_name" value="{{isset($client->client_name) ? $client->client_name : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_surname')</label>
                    </div>
                    <div class="form_input">
                        <input type="text" name="surname" value="{{isset($client->surname) ? $client->surname : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label" id="address">
                        <label>@lang('admin/clients.client_address')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="address" value="{{isset($client->address) ? $client->address : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_postal_code')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="postal_code" value="{{isset($client->postal_code) ? $client->postal_code : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_city')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="city" value="{{isset($client->city) ? $client->city : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_country')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="country" value="{{isset($client->country) ? $client->country : ''}}" class="input">
                    </div>
                </div>

                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_email')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="email" value="{{isset($client->email) ? $client->email : ''}}" class="input">
                    </div>
                </div>

                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_telephone')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="telephone" value="{{isset($client->telephone) ? $client->telephone : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_order_id')</label>
                    </div>

                    <div class="form_input">
                        <input type="text" name="order_id" value="{{isset($client->order_id) ? $client->order_id : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_date_ordered')</label>
                    </div>

                    <div class="form_input">
                        <input type="date" name="date_ordered" value="{{isset($client->date_ordered) ? $client->date_ordered : ''}}" class="input">
                    </div>
                </div>
                
                <div class="form_group">
                    <div class="form_label">
                        <label>@lang('admin/clients.client_date_sended')</label>
                    </div>

                    <div class="form_input">
                        <input type="date" name="date_sended" value="{{isset($client->date_sended) ? $client->date_sended : ''}}" class="input">
                    </div>
                </div>

                <div class="form_group">
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

            </form>

            <div class="form_submit">
                <button id="send">@lang('admin/clients.client_send')</button>
            </div>
                
        </div>


@endsection
