<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'city_id' => 'required | exists:cities,id',
            'street_name' => 'required | string',
            'building' => 'required | string',
            'district' => 'required | string',
            'nearest_landmark' => 'nullable | string',
            'address_type' => 'required | string ',
        ];
    }
}
