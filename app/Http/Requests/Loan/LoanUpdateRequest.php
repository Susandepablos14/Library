<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoanUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('loans.updated');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking_id'  => 'required|exists:bookings,id',
        ];

    }
}
