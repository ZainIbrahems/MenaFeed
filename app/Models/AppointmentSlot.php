<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class AppointmentSlot extends Model
{

    protected $table = 'appointment_slots';

    public function currency_object(){
        return $this->belongsTo(Currency::class,'currency');
    }


    public function scopeShow($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            $provider = Provider::where('user_id',auth('web')->user()->id)->first();
            return $q->where('provider_id', '=', $provider->id);
        }
        return $q;
    }
}
