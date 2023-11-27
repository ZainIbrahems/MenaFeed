<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ProvidersCme extends Model
{
    protected $table = 'providers_cme';

    public function scopeShow($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            return $q->where('provider_id', '=', auth('web')->user()->id);
        }
        return $q;
    }
}
