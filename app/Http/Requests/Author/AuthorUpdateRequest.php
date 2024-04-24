<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AuthorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('authors.updated');
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
            'biography' => 'nullable|string|min:3',
            'birthdate' => 'required|date|before:today',
            'country_id' => 'required|exists:countries,id',
            'image' => 'nullable|dimensions:min_width=30,min_height=30,max_width=80,max_height=80',
        ];

    }
}
