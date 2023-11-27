<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class ProviderAward extends Model
{
    protected $table = 'provider_awards';


    use Translatable;

    protected $translatable = ['title', 'authority_name'];
}
