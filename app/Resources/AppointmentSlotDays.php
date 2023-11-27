<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentSlotDays extends JsonResource
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
            'day' => (int)$this->day
        ];
    }
}
