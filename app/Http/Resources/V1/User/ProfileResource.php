<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\User\ContactCollection;
use App\Models\User\UserContact;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'username'          => $this->username,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'is_active'         => $this->isActive(),
            //'role'              => $this->getStoredRole(),
            'profile_photo_url' => $this->profile_photo_url,
            'phone_number'     => $this->phone_number,
        ];
    }
}
