<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Spatial;
use TCG\Voyager\Traits\Translatable;

class AttributeOption extends Model
{
    use HasFactory;
    use Spatial;
    use Translatable;
    use SoftDeletes;

    protected $table = 'attribute_options';
    protected $translatable = ['value'];
}
