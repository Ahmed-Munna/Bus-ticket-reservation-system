<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageStaffRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'gender' => ['string', 'max:50'],
            'photo' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'cv' => ['mimes:pdf,zip', 'max:10240'],
            'role' => ['required', 'in:area-manager, counter-manager, driver'],
            'phone' => ['string', 'max:50'],
            'em_phone' => ['string', 'max:50'],
            'address' => ['string', 'max:255'],
            'city' => ['string', 'max:50'],
            'country' => ['string', 'max:50'],
            'city' => ['string', 'max:50'],
            'zip' => ['string', 'max:10'],
            'discription' => ['string', 'max:255'],
        ];
    }
}
