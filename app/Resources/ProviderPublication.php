<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderPublication extends JsonResource
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
            'paper_title' => $this->paper_title,
            'summary' => $this->summary,
            'publisher' => $this->publisher,
            'published_url' => $this->published_url,
            'published_date' => $this->published_date,
        ];
    }
}
