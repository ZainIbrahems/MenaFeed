<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class PlatformSubSubCategory extends Model
{

    use Translatable;
    use SoftDeletes;

    protected $table = 'platform_sub_sub_categories';
    protected $translatable = ['name'];
}
