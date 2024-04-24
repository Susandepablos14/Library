<?php

namespace App\Http\Requests\Editorial;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditorialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('editorials.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'address' => 'required|string|min:3',
            'phone' => 'required|regex:/^\+/',
            'email'      => 'required|string|min:3|unique:editorials',
            'country_id' => 'required|exists:countries,id',
            'image' => 'required|dimensions:min_width=30,min_height=30,max_width=80,max_height=80',
        ];
         //
    }
}
