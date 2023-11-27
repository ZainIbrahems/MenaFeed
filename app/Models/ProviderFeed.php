<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderFeed extends Model
{

    protected $table = 'provider_feeds';


    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function comments()
    {
        return $this->hasMany(ProviderFeedComment::class, 'feed_id');
    }

    public function likes()
    {
        return $this->hasMany(ProviderFeedLike::class, 'feed_id');
    }

    public function scopeActive($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            return $q->where('provider_id', auth('web')->user()->id);
        } else {
            return $q;
        }
    }
}
