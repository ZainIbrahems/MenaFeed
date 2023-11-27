<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class BlogsCategory extends Model
{

    use Translatable;

    protected $translatable = ['title'];

    protected $table = 'blogs_categories';

    function children()
    {
        return $this->hasMany(BlogsCategory::class,'parent_id');
    }

    function scopeParent($q){
        return $q->where('parent_id',NULL);
    }
}
