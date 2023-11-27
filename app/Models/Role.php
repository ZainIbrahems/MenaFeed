<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Role extends \TCG\Voyager\Models\Role
{
    protected $table = 'roles';
}
