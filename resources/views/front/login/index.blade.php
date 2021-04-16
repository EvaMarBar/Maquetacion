@extends('front.layout.master')

@section('content')

<div class="login">
    <div class="login-errors">
        @include('front.layout.errors')
    </div>    

    <div class="form-content">

        <form class="front-form" id="users-form" method="POST" action="{{route('front_login_submit')}}" autocomplete="off">

            {{ csrf_field() }}
            
            <div class="form_group">
                <div class="form_label">
                    <label>Email</label>
                </div>
                <div class="form_input" id="editor">
                    <input type="email" name="email" value="" class="input">
                </div>
            </div>
            
            <div class="form_group">
                <div class="form_label">
                    <label>Contraseña</label>
                </div>
                <div class="form_input">
                    <input type="password" name="password" value="" class="input">
                </div>
            </div>
            
        <div class="form_submit">
            <button type="submit" id="send">Enviar</button>
        </div>

        </form>
            
    </div>
</div>


@endsection