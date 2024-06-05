<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'gender' => ['string', 'max:50'],
            'old_photo' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'photo' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'old_cv' => ['mimes:pdf,zip', 'max:20480'],
            'cv' => ['mimes:pdf,zip', 'max:20480'],
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
