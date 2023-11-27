<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class PlatformCategory extends Model
{

    use Translatable;
    use SoftDeletes;

    protected $table = 'platform_categories';
    protected $translatable = ['name'];
}
