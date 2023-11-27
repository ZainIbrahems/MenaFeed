<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class ProviderExperience extends Model
{
    protected $table = 'provider_experiences';

    use Translatable;
    protected $translatable = ['place_of_work', 'designation'];

}
