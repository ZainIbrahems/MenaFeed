<?php

namespace App\Resources;

use App\Models\JobsLike;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class JobBref extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $likes = JobsLike::where('job_id', $this->id)->count();

        $is_liked = false;
        $is_mine = false;
        if (auth('sanctum')->check()) {
            $user_id = auth('sanctum')->user()->id;
            $from_type = getUserType();

            $is_liked = (bool)JobsLike::where([
                'user_id' => $user_id,
                'user_type' => $from_type,
                'job_id' => $this->id,
            ])->first();

            $from_type = getUserType();
            $provider_id = auth('sanctum')->user()->id;
            $is_mine = false;
            if ($from_type == 'provider' && $this->provider_id == $provider_id) {
                $is_mine = true;
            }
        }


        return [
            'id' => (int)$this->id,
            'title' => $this->title,
            'provider_id' => $this->provider_id,
            'short_description' => $this->short_description,
            'type_id' => $this->type_id,
            'classification_id' => $this->classification_id,
            'address_text' => $this->address_text,
            'is_mine' => $is_mine,
            'likes' => $likes,
            'is_liked' => $is_liked,
            'type' => $this->type ? JobsType::make($this->type) : null,
            'classification' => $this->type ? JobsClassification::make($this->classification) : null,
            'created_at' => Carbon::parse($this->created_at)->toDateString(),
        ];
    }
}
