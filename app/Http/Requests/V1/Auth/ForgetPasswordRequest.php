<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomException;
use App\Models\User\User;
use Illuminate\Http\Response;

class ForgetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!User::where('email',$this->email)->first()){
            throw new CustomException('The email you entered isn\'t registered', Response::HTTP_BAD_REQUEST);
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
            'email' => 'required|exists:App\Models\User\User,email'
        ];
    }
}
