<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Traits\Translatable;

class SubscriptionType extends Model
{
    use Translatable;
    use SoftDeletes;

    protected $translatable = ['name'];
    protected $table = 'subscription_types';


    public function features(){
        return $this->belongsToMany(SubscriptionFeature::class,
            'subscription_types_features','subscription_type_id');
    }

}
