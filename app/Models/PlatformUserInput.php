<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class PlatformUserInput extends Model
{
    use Translatable;
    use SoftDeletes;
    protected $translatable = ['title', 'description'];
    protected $table = 'platform_user_inputs';

    public function extensions(){
        return $this->belongsToMany(Extension::class,'inputs_extensions','platform_user_input_id');
    }
}
