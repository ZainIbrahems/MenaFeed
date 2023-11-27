<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentSlot extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $professional = \App\Models\Provider::where('id', $this->professional_id)->first();
        $facility = \App\Models\Provider::where('id', $this->facility_id)->first();
        $appointment_type = \App\Models\AppointmentType::where('id', $this->appointment_type)->first();
        $times = \App\Models\AppointmentSlotTimes::where('slot_id', $this->id)->get();
        $days = \App\Models\AppointmentSlotDays::where('slot_id', $this->id)->pluck('day');
        return [
            'id' => (int)$this->id,
            'provider_id' => $this->provider_id,
            'appointment_type_data' => $appointment_type ? AppointmentType::make($appointment_type) : null,
            'appointment_type' => $this->appointment_type,
            'date_time' => Carbon::parse($this->date_time)->toDateTimeLocalString(),
            'professional_data' => $professional ? ProviderBref::make($professional) : null,
            'facility_data' => $facility ? ProviderBref::make($facility) : null,
            'facility_id' => $this->facility_id,
            'professional_id' => $this->professional_id,
            'fees' => $this->fees,
            'currency' => $this->currency,
            'is_free' => $this->fees == 0,
            'price' => $this->fees . ' ' . ($this->currency_object ? $this->currency_object->symbole : ''),
            'times' => \App\Resources\AppointmentSlotTimes::collection($times),
            'days' => $days
        ];
    }
}
