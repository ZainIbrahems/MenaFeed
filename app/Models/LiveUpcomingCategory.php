<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class LiveUpcomingCategory extends Model
{
    protected $table = 'live_upcoming_categories';
    use Translatable;

    protected $translatable = ['name'];
}
