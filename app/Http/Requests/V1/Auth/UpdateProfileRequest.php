<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|nullable|min:4|max:255',
            'first_name' => 'sometimes|nullable|alpha|min:4|max:100',
            'last_name' => 'sometimes|nullable|alpha|min:4|max:100',
            'email' => ["sometimes", "nullable", Rule::unique('users', 'email')->ignore(Auth::user()->id), "email", "max:255"],
            'password' => 'sometimes|confirmed|min:6',
            'country_id' => 'sometimes|nullable|exists:countries,id',
            'phone_number' => ["sometimes", "nullable",  Rule::unique("users", 'phone_number')->ignore(Auth::user()->id), "numeric"],
        ];
    }
}
