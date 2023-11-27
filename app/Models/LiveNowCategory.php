<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class LiveNowCategory extends Model
{
    protected $table = 'live_now_categories';
    use Translatable;

    protected $translatable = ['name'];

    public function scopeShow($q)
    {
        $role = auth('web')->user()->role_id;
        if ($role != getRoleID('admin') && $role != getRoleID('nm-admin') && $role != getRoleID('super-admin')) {
            return $q->where('platform_id', auth('web')->user()->platform_id);
        }
    }
}
