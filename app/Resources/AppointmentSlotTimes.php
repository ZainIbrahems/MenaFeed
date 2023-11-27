<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentSlotTimes extends JsonResource
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
            'from_time' => Carbon::parse($this->from_time)->format('h:i A'),
            'to_time' => Carbon::parse($this->to_time)->format('h:i A'),
        ];
    }
}
