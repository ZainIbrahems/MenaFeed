<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Spatial;
use TCG\Voyager\Traits\Translatable;

class Job extends Model
{
    use Translatable;
    use Spatial;

    protected $spatial = ['location'];

    protected $translatable = [
        'title',
        'short_description',
        'core_expertise',
        'summary',
    ];


    protected $table = 'jobs';

    function type()
    {
        return $this->belongsTo(JobsType::class, 'type_id');
    }

    function classification()
    {
        return $this->belongsTo(JobsClassification::class, 'classification_id');
    }

    function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
