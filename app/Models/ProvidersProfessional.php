<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ProvidersProfessional extends Model
{
    protected $table = 'providers_professionals';

    public function provider(){
        return $this->belongsTo(Provider::class,'provider_id');
    }
}
