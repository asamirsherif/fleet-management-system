<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomException;
use Illuminate\Http\Response;

class ActivateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->user()) {
            throw new CustomException(trans('auth.not_authorized_for_validation'), Response::HTTP_UNAUTHORIZED);
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
            //
        ];
    }
}
