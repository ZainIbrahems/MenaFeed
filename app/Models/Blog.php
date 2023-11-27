<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Blog extends Model
{
    use Translatable;

    protected $translatable = ['title', 'content'];

    protected $table = 'blogs';

    function category()
    {
        return $this->belongsTo(BlogsCategory::class, 'category_id');
    }

    function sub_category()
    {
        return $this->belongsTo(BlogsCategory::class, 'sub_category_id');
    }

    function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    function blogs_views(){
        return $this->hasMany(BlogView::class,'blogs_id');
    }



    function scopeMy($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            $q->where('provider_id', auth('web')->user()->id);
        }
    }
}
