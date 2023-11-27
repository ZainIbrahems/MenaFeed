<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class UpcomingLivestream extends Model
{
    protected $table = 'upcoming_livestreams';
    use Translatable;

    protected $translatable = ['title', 'goal', 'topic'];


    public function upcoming_livestreams_category()
    {
        return $this->belongsTo(UpcomingLivestream::class, 'upcoming_livestreams_id');
    }

    public function scopeShow($q)
    {
        $role = auth('web')->user()->role_id;
        if ($role != getRoleID('admin') && $role != getRoleID('nm-admin') && $role != getRoleID('super-admin')) {
            return $q->where('added_by', auth('web')->user()->id);
        }
    }
}
