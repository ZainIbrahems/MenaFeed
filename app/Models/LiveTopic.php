<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use TCG\Voyager\Traits\Translatable;

class LiveTopic extends Model
{
    protected $table = 'live_topics';
    use Translatable;
    protected $translatable = ['title'];
}
