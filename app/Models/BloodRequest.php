<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Spatial;
use TCG\Voyager\Traits\Translatable;

class BloodRequest extends Model
{

    use Spatial;

    protected $spatial = ['location'];
    protected $table = 'blood_requests';


}
