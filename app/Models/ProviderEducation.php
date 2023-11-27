<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ProviderEducation extends Model
{
    protected $table = 'providers_educations';


    use Translatable;

    protected $translatable = ['university_name'];
}
