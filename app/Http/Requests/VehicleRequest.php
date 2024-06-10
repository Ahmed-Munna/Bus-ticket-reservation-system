<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            "vehicle_name" => "required | string | max:255",
            "vehicle_type_id" => "required",
            "registration_number" => "required | string | max:255",
            "chasis_number" => "required | string | max:255",
            "engine_number" => "required | string | max:255",
            "model" => "required | string | max:255",
            "owner_name" => "required | string | max:255",
            "owner_phone" => "required | string | max:255",
            "brand_name" => "required | string | max:255",
            "status" => "boolean",
        ];
    }
}
