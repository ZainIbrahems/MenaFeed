<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class AppointmentClient extends Model
{

    protected $table = 'appointment_clients';

    public function scopeShow($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            $provider = Provider::where('user_id',auth('web')->user()->id)->first();
            return $q->
            join('appointment_slots','appointment_slots.id','=','appointment_clients.appointment_slot_id')->
            where('appointment_slots.provider_id', '=', $provider->id);
        }
        return $q;
    }
}
