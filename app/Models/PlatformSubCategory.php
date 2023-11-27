<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class PlatformSubCategory extends Model
{

    use Translatable;
    use SoftDeletes;

    protected $table = 'platform_sub_categories';
    protected $translatable = ['name'];

    public function subSubCategories(){
        return $this->hasMany(PlatformSubSubCategory::class,'sub_category_id');
    }
}
