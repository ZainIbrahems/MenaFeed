<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformCategorySelect2 extends JsonResource
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
            'slug' => slugify($this->name),
            'text' => $this->name
        ];
    }
}
