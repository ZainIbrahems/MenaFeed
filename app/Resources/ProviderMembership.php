<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderMembership extends JsonResource
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
            'authority_name' => $this->authority_name,
        ];
    }
}
