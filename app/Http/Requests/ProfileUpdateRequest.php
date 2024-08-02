<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'max:3000'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'license' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'integer', 'max:100'],
            'landline' => ['nullable', 'integer', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'vat' => ['nullable', 'string', 'max:255'],
            'siret_number' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255']
        ];
    }
}
