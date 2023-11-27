<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Livestream extends Model
{
    protected $table = 'livestreams';
    use Translatable;

    protected $translatable = ['title', 'goal', 'topic'];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'added_by');
    }

    public function live_now_category()
    {
        return $this->belongsTo(LiveNowCategory::class, 'live_now_category_id');
    }

    public function scopeShow($q)
    {
        $role = auth('web')->user()->role_id;
        if ($role != getRoleID('admin') && $role != getRoleID('nm-admin') && $role != getRoleID('super-admin')) {
            return $q->where('added_by', auth('web')->user()->id);
        }
    }
    
    public function likes(){
        return $this->hasMany(LiveStreamReaction::class)->where('type', 1);
    }

    public function dis_likes(){
        return $this->hasMany(LiveStreamReaction::class)->where('type', 0);
    }

    public function comments(){
        return $this->hasMany(LiveStreamComment::class);
    }

}
