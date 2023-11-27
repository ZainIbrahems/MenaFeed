<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class MeetingType extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $translatable = ['title'];

    protected $table = 'meeting_types';
}
