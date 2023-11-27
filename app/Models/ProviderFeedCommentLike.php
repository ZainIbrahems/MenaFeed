<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class ProviderFeedCommentLike extends Model
{
    protected $table = 'provider_feeds_comments_likes';
}
