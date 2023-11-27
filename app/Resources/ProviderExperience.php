<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderExperience extends JsonResource
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
            'place_of_work' => $this->place_of_work,
            'designation' => $this->designation,
            'starting_year' => $this->starting_year,
            'ending_year' => $this->ending_year,
            'currently_working' => (int)$this->currently_working,
        ];
    }
}
