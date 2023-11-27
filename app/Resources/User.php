<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => (int)$this->id,
            'personal_picture' => getImageURL($this->personal_picture),
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'platform' => Platform::make($this->platform),
            'provider_type' => $this->provider_type,
            'role_id' => $this->role_id,
            'role_name' => getRoleName($this->role_id),
            'phone_verified_at' => $this->phone_verified_at,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString()
        ];
    }

}
