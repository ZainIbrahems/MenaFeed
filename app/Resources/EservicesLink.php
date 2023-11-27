<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EservicesLink extends JsonResource
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
            'logo' => getImageURL($this->logo),
            'title' => $this->title,
            'link' => $this->link,
//            'category_id' => $this->category_id
        ];
    }
}
