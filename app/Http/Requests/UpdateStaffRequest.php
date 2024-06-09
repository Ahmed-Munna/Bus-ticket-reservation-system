<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
        // dd($this->all());
        return [
            'first_name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'gender' => ['string', 'max:50'],
            'old_photo' => ['string'],
            'photo' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'old_cv' => ['string'],
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
