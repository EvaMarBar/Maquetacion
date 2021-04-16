<?php

/*
|--------------------------------------------------------------------------
| Validaciones del formulario de la sección FAQ's
|--------------------------------------------------------------------------
|
| **authorize: determina si el usuario debe estar autorizado para enviar el formulario. 
|
| **rules: recoge las normas que se deben cumplir para validar el formulario. Los errores son 
|   devueltos en forma de objeto JSON en un error 422.
| 
| **messages: mensajes personalizados de error.
|    
*/

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_name' => 'required',
            'surname' => 'required',
            'postal_code' => 'required|numeric',
            'city' => 'required',
            // 'country' => 'required',
            'email'=>'required_without:id',
            'telephone' => 'required|numeric',
            'order_id' => 'required|numeric',
            'date_ordered' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'surname.required' => 'El apellido es obligatorio',
            'postal_code.required'=> 'El código postal es obligatorio',
            'city.required'=> 'La ciudad es obligatoria',
            'country.required'=> 'El país es obligatorio',
            'email.required_without' => 'El email es obligatorio',
            'telephone.required' => 'El teléfono es obligatorio',
            'order_id.required'=> 'El número de pedido es obligatorio',
            'date_ordered.required'=> 'La fecha de pedido es obligatoria',
            'postal_code.numeric' => 'El código postal debe ser un número',
            'telephone.numeric' => 'El teléfono tiene que ser un número',
            'order_id.numeric' => 'El númerp de pedido debe ser un número',
            'date_ordered.date' => 'La fecha de pedido debe ser una fecha',
        ];
    }
}
