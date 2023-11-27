<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class EservicesCategory extends Model
{

    use Translatable;

    protected $translatable = ['title'];

    protected $table = 'eservices_categories';

    public function links()
    {
        return $this->hasMany(EservicesLink::class, 'category_id');
    }
}
