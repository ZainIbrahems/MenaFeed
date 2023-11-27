<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ItemCategory extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $table = 'item_categories';
    protected $translatable = ['name'];
}
