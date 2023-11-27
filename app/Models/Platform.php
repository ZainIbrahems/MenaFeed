<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class Platform extends Model
{

    use Translatable;
    use SoftDeletes;

    protected $table = 'platforms';
    protected array $translatable = ['name', 'description'];

    public function scopeShow($q)
    {
        $role = auth('web')->user()->role_id;
        if ($role != getRoleID('admin') && $role != getRoleID('nm-admin') && $role != getRoleID('super-admin')) {
            return $q->where('id', auth('web')->user()->platform_id);
        }
    }
}
