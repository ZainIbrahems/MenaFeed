<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class PaymentGateWay extends Model
{

    use Translatable;
    use SoftDeletes;

    protected $table = 'payment_gate_ways';
    protected $translatable = ['title'];

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }
}