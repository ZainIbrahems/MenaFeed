<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LiveNowCategory extends JsonResource
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
            'platform_id' => $this->platform_id,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
