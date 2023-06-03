<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User\User;
use App\Exceptions\CustomException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CustomerSignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (User::where('email', $this->input('email'))->exists()) {
            throw new CustomException(trans('auth.user_with_this_email_exist'), Response::HTTP_LOCKED);
        }

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
            'name' => 'required|min:4|max:255',
            'first_name' => 'alpha|min:4|max:100',
            'last_name' => 'alpha|min:4|max:100',
            'email' => ["required", Rule::unique('users', 'email'), "email", "max:255"],
            'password' => 'required|confirmed|min:6',
            'phone_number' => ["required",  Rule::unique("users", 'phone_number'), "string"],
        ];
    }
}
