<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderVacation extends JsonResource
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
            'certificate_name' => $this->certificate_name,
            'issue_date' => $this->issue_date,
        ];
    }
}
