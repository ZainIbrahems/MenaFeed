<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ProviderVacation extends Model
{
    protected $table = 'provider_vacations';

    use Translatable;
    protected $translatable = ['certificate_name'];
}
