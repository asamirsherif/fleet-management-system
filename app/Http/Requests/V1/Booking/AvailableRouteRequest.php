<?php

namespace App\Http\Requests\V1\Booking;

use Illuminate\Foundation\Http\FormRequest;

class AvailableRouteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'start_station_id' => 'required|different:end_station_id|exists:stations,id',
            'end_station_id' => 'required|exists:stations,id',
        ];
    }

        /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_station_id.required' => 'The start station ID is required.',
            'start_station_id.different' => 'The start and end station IDs must be different.',
            'start_station_id.exists' => 'The selected start station is invalid.',
            'end_station_id.required' => 'The end station ID is required.',
            'end_station_id.exists' => 'The selected end station is invalid.',
        ];
    }

}
