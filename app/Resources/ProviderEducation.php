<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderEducation extends JsonResource
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
            'university_name' => $this->university_name,
            'degree' => $this->degree,
            'starting_year' => $this->starting_year,
            'ending_year' => $this->ending_year,
            'currently_pursuing' => (int)$this->currently_pursuing,
        ];
    }
}
