<?php

namespace App\Http\Resources\V1\Auth;

use App\Http\Resources\V1\User\ContactCollection;
use App\Http\Resources\V1\User\UserContactResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    private $token;

    public function __construct($resource, $token)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

        $this->token = $token;
    }

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
            'uid'               => $this->uid,
            'name'              => $this->name,
            'email'             => $this->email,
            'username'          => $this->username,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'is_active'         => $this->isActive(),
            //'role'              => $this->roles_names,
            'profile_photo_url' => $this->profile_photo_url,
            'token'             => $this->token,
            'phone_number'     => $this->phone_number,
        ];
    }
}
