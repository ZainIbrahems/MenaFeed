<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class ProviderPublication extends Model
{
    protected $table = 'providers_publications';


    use Translatable;

    protected $translatable = ['paper_title', 'summary', 'publisher'];

}
