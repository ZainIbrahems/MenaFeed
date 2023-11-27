<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class JobsType extends Model
{
    use Translatable;

    protected $translatable = ['title'];

    protected $table = 'jobs_type';
}
