<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Traits\Translatable;

class Live extends Model
{
    protected $table = 'lives';
    use Translatable;

    protected $translatable = ['title', 'goal'];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'added_by');
    }

    public function live_now_category()
    {
        return $this->belongsTo(LiveNowCategory::class, 'live_now_category_id');
    }

    public function topic()
    {
        return $this->belongsTo(LiveTopic::class, 'topic_id');
    }


    public function scopeShow($q)
    {
        $role = auth('web')->user()->role_id;
        if ($role != getRoleID('admin') && $role != getRoleID('nm-admin') && $role != getRoleID('super-admin')) {
            $provider = Provider::where('user_id', auth('web')->user()->id)->first();
            if ($provider) {
                return $q->where('added_by', $provider->id);
            } else {
                return $q->where('added_by', -1);
            }
        }
    }

}
