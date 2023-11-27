<?php

namespace App\Resources;

use DNS2D;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentClient extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $qr = 'data:image/png;base64,' . DNS2D::getBarcodePNG($this->id, 'PDF417');
        $professional = \App\Models\Provider::where('id', $this->professional_id)->first();
        $facility = \App\Models\Provider::where('id', $this->facility_id)->first();
        if ($this->from_type == 'client') {
            $user = \App\Models\Client::where('id', $this->user_id)->first();
            $user = $user ? Client::make($user) : null;
        } else {
            $user = \App\Models\Provider::where('id', $this->user_id)->first();
            $user = $user ? ProviderBref::make($user) : null;
        }
        $appointment_slot = \App\Models\AppointmentSlot::where('id', $this->appointment_slot_id)->first();
        return [
            'id' => (int)$this->id,
            'for_who' => $this->for_who,
            'user_id' => $this->user_id,
            'user_data' => $user,
            'professional_id' => $this->professional_id,
            'professional_data' => $professional ? ProviderBref::make($professional) : null,
            'facility_id' => $this->facility_id,
            'facility_data' => $facility ? ProviderBref::make($facility) : null,
            'appointment_slot_id' => $this->appointment_slot_id,
            'appointment_slot_data' => $appointment_slot ? AppointmentSlot::make($appointment_slot) : null,
            'full_name' => $this->full_name,
            'birthdate' => $this->birthdate,
            'id_number' => $this->id_number,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'id_front' => getImageURL($this->id_front),
            'id_back' => getImageURL($this->id_back),
            'insurance_front' => getImageURL($this->insurance_front),
            'insurance_back' => getImageURL($this->insurance_back),
            'comments' => $this->comments,
            'payment_status' => $this->payment_status,
            'state' => $this->state,
            'qr' => $qr
        ];
    }
}
