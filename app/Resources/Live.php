<?php

namespace App\Resources;

use App\Models\ProviderLivestream;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Live extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $is_co_host = false;
        if (auth('sanctum')->check()) {
            $is_co_host = (bool)ProviderLivestream::where([
                'provider_id' => auth('sanctum')->user()->id,
                'live_id' => $this->id,
            ])->first();
        }

        return [
            'id' => (int)$this->id,
            'category' => LiveNowCategory::make($this->live_now_category),
            'image' => $this->image ? getImageURL($this->image) : asset('widgets/back.png'),
            'title' => $this->title,
            'goal' => $this->goal,
            'topic' => $this->topic && is_object($this->topic) ? $this->topic->title : "",
            'duration' => $this->duration,
            'room_id' => $this->code,
            'status' => $this->status,
            'is_co_host' => $is_co_host,
            'share_link' => "https://menaaii.com/live/" . $this->code,
            'provider' => ProviderBref::make($this->provider),
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
        ];
    }
}
