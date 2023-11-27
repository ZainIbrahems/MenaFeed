<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class HomeSection extends Model
{
    use Translatable;

    protected $translatable = ['title'];
    protected $table = 'home_sections';

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }
}
