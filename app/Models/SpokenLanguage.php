<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;
use TCG\Voyager\Traits\Spatial;

class SpokenLanguage extends Model
{
    use Translatable;
    use SoftDeletes;
    use Spatial;

    public $timestamps = false;
    protected $translatable = ['name'];

    public function language(){
        return $this->belongsTo(SpokenLanguage::class);
    }
}
