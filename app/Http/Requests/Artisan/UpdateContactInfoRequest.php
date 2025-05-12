<?php

namespace App\Http\Requests\Artisan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city_id' => 'nullable|exists:cities,id',
            'country_id' => 'nullable|exists:countries,id',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ];
    }
}
