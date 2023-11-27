<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionType extends JsonResource
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
            'features' => SubscriptionFeature::collection($this->features),
            'monthly_fee' => $this->monthly_fee,
            'yearly_fee' => $this->yearly_fee,
        ];
    }
}
