<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EservicesBanner extends JsonResource
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
            'image' => getImageURL($this->image),
//            'platform_id' => $this->platform_id
        ];
    }
}
