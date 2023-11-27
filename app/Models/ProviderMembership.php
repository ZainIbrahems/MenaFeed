<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ProviderMembership extends Model
{
    protected $table = 'provider_membership';

    use Translatable;
    protected $translatable = ['name'];
}
