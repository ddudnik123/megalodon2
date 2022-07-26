<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_id' => ['required', 'integer', 'exists:company_types,id'],
            'name' => ['required', 'string', 'min:3'],
            'bin' => ['required', 'string', 'min:12', 'max:13'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'lat' => ['required', 'numeric'],
            'lon' => ['required', 'numeric'],
            'full_address' => ['required', 'string', 'max:255'],
            'contacts.*.type' => ['required', 'in:site,email,phone,home_phone', 'string'],
            'contacts.*.contact_name' => ['required_if:contacts.type,phone,home_phone', 'string', 'min:2', 'max:20'],
            'contacts.*.value' => ['required', 'string'],
        ];
    }
}
