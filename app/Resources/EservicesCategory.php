<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EservicesCategory extends JsonResource
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
            'title' => $this->title,
            'links' => EservicesLink::collection($this->links->translate(app()->getLocale(), 'fallbackLocale')),
//            'platform_id' => $this->platform_id
        ];
    }
}
