<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class EservicesLink extends Model
{

    use Translatable;

    protected $translatable = ['title'];

    protected $table = 'eservices_links';
}
