<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UpcomingLivestream extends JsonResource
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
            'category' => LiveNowCategory::make($this->upcoming_livestreams_category),
            'image' => $this->image ? getImageURL($this->image) : asset('widgets/back.png'),
            'title' => $this->title,
            'goal' => $this->goal,
            'topic' => $this->topic,
            'status' => $this->status,
            'date_time' => Carbon::parse($this->date_time)->toDateTimeString(),
            'provider' => ProviderBref::make($this->provider),
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
