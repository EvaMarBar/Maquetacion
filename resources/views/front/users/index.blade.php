@extends('front.layout.table_form')

@section('table')

<div class="form-content">

    <form class="admin-form" id="userss-form" action="{{route("users_store")}}" autocomplete="off">

        {{ csrf_field() }}

        <div class="form_group">
            <div class="form_label">
                <label> Nombre</label>
            </div>

            <div class="form_input">
                <input type="text" name="name" value="{{isset($user->name) ? $user->name : ''}}" class="input">
            </div>
        </div>
        
        <div class="form_group">
            <div class="form_label">
                <label>Email</label>
            </div>
            <div class="form_input" id="editor">
                <input type="email" name="email" value="{{isset($user->email) ? $user->email : ''}}" class="input">
            </div>
        </div>
        
        <div class="form_group">
            <div class="form_label">
                <label>Contraseña</label>
            </div>
            <div class="form_input">
                <input type="password" name="password" value="{{isset($user->password) ? $user->password : ''}}" class="input">
            </div>
        </div>

    </form>

    <div class="form_submit">
        <button id="send">Enviar</button>
    </div>
        
</div>


@endsection