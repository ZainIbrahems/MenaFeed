<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class AppointmentSlotDays extends Model
{
    protected $table = 'appointment_slots_days';
    public $timestamps = false;
}
