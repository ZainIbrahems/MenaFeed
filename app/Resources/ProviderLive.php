<?php

namespace App\Resources;

use App\Models\UserFollow;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderLive extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $location = \App\Models\Provider::select(DB::raw('ST_Y(location) as y,ST_X(location) as x'))->where('id', $this->id)->first();
        $lat = $location && !is_null($location->y) ? $location->y : '25.2048';
        $lng = $location && !is_null($location->x) ? $location->x : '55.2708';
        $likes = 0;
        $followers = 0;
        $reviews_rate = 0;
        $reviews_count = 0;
        $is_following = false;
        if (auth('sanctum')->user()) {
            $is_following = (bool)UserFollow::where([
                'user_id' => auth('sanctum')->user()->id,
                'user_type' => getUserType(),
                'followed_id' => $this->id,
                'followed_type' => 'provider',
            ])->first();
        }
        $distance = getProviderDistance($request, $location);
        return [
            'id' => (int)$this->id,
            'image' => $this->personal_picture ? getImageURL($this->personal_picture) : \Voyager::image(setting('admin.bg_image')),
            'name' => $this->full_name ? $this->full_name : '',
            'phone' => $this->phone ? $this->phone : '',
            'email' => $this->email ? $this->email : '',
            'distance' => $distance,
            'lat' => strval($lat),
            'lng' => strval($lng),
            'likes' => $likes,
            'followers' => $followers,
            'reviews_rate' => $reviews_rate,
            'reviews_count' => $reviews_count,
            'is_following' => $is_following,
            'room_id' => $this->code,
            'share_link' => "https://menaaii.com/live/" . $this->code,
            'verified' => (int)$this->verified,
        ];
    }

}
