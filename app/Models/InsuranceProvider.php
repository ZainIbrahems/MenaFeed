<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class InsuranceProvider extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $translatable = ['name'];

    protected $table = 'insurance_providers';
}
