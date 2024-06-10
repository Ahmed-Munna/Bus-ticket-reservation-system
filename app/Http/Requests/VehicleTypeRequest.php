<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'seat_layout' => 'required |in:2 x 2,2 x 3,3 x 2,3 x 3,1 x 2,1 x 3',
            'number_of_seats' => 'required | string | max:255',
            'status' => 'required|boolean',
            'has_ac' => 'required|boolean'
        ];
    }
}
