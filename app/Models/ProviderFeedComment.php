<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ProviderFeedComment extends Model
{
    protected $table = 'provider_feeds_comments';

    public function replies()
    {
        return $this->hasMany(ProviderFeedComment::class, 'comment_id')->orderBy('id','desc');
    }
}
