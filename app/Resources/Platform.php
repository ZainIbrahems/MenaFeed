<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Platform extends JsonResource
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
            'name' => $this->name,
            'image' => getImageURL($this->image),
            'ranking' => $this->ranking,
            'video' => $this->video ? getFileURL($this->video) : '',
        ];
    }
}
