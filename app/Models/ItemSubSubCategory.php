<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ItemSubSubCategory extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $table = 'item_sub_sub_categories';
    protected $translatable = ['name'];
}
