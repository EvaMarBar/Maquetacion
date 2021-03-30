@extends('admin.layout.table_form')

@section('table')

    <table>
        <tr>
            <th> Id </th>
            <th> Pregunta </th>
            <th> Respuesta </th>
            <th> Acciones </th>
        </tr>

        @foreach($faqs as $faq_element)
            <tr>
                <td> {{$faq_element->id}} </td>
                <td> {{$faq_element->title}} </td>
                <td>{{$faq_element->description}}</td>
                <td>
                    <svg class="edit-button" data-url="{{route('faqs_show', ['faq' => $faq_element->id])}}" style="width:24px;height:24px" viewBox="0 0 24 24" >
                        <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12H20A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4V2M18.78,3C18.61,3 18.43,3.07 18.3,3.2L17.08,4.41L19.58,6.91L20.8,5.7C21.06,5.44 21.06,5 20.8,4.75L19.25,3.2C19.12,3.07 18.95,3 18.78,3M16.37,5.12L9,12.5V15H11.5L18.87,7.62L16.37,5.12Z" />
                    </svg>
                    <svg class="delete-button" data-url="{{route('faqs_destroy', ['faq' => $faq_element->id])}}"style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M16,10V17A1,1 0 0,1 15,18H9A1,1 0 0,1 8,17V10H16M13.5,6L14.5,7H17V9H7V7H9.5L10.5,6H13.5Z" />
                    </svg>
                </td>
            </tr>
        @endforeach

    </table>
    
@endsection

@section('form')

<div class="form_content">

    <form class="admin-form" id="faqs-form" action="{{route("faqs_store")}}" autocomplete="off">

        {{ csrf_field() }}

        <input autocomplete="false" name="hidden" type="text" style="display:none;">
        <input type="hidden" name="id" value="{{isset($faq->id) ? $faq->id : ''}}">

        <div class="form_group">
            <div class="form_label">
                <label>Pregunta</label>
            </div>

            <div class="form_input">
                <input type="text" name="title" value="{{isset($faq->title) ? $faq->title : ''}}" class="input">
            </div>
        </div>
        
        <div class="form_group">
            <div class="form_label">
                <label>Respuesta</label>
            </div>
            <div class="form_input">
                <textarea name="description" class="input" rows="5">{{isset($faq->description) ? $faq->description : ''}}</textarea>
            </div>
        </div>
    </form>
</div>

<div class="form_submit">
    <button id="send">Enviar</button>
</div>

@endsection
