<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvidersCme extends JsonResource
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
            'source_type' => $this->source_type,
            'end_year' => $this->end_year,
            'start_year' => $this->start_year,
            'cme_accredited_by' => $this->cme_accredited_by,
            'points' => $this->points,
            'certificate' => getImageURL($this->certificate),
        ];
    }
}
