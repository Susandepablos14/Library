<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('books.updated');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'editorial_id' => 'required|exists:editorials,id',
            'publication_date' => 'required|string',
            'image' => 'nullable|dimensions:min_width=100,min_height=150,max_width=400,max_height=600',
        ];

    }
}
