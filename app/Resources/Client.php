<?php

namespace App\Resources;

use App\Models\UserFollow;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Client extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $is_following = false;
        if (auth('sanctum')->user()) {
            $is_following = (bool)UserFollow::where([
                'user_id' => auth('sanctum')->user()->id,
                'user_type' => getUserType(),
                'followed_id' => $this->id,
                'followed_type' => 'client',
            ])->first();
        }

        return [
            'id' => (int)$this->id,
            'personal_picture' => getImageURL($this->personal_picture),
            'full_name' => $this->full_name,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_following' => $is_following,
            'platform' => Platform::make($this->platform),
            'provider_type' => $this->provider_type,
            'role_id' => 1,
            'role_name' => 'client',
            'phone_verified_at' => $this->phone_verified_at,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString()
        ];
    }

}
