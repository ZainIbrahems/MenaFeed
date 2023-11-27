<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveTopic extends JsonResource
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
            'title' => $this->name,
            'image' => $this->image ? getImageURL($this->image) : asset('widgets/back.png'),
            'platform_id' => $this->platform_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
