<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProviderSpokenLanguage extends Model
{
    public $timestamps = false;
    
    public function language(){
        return $this->belongsTo(SpokenLanguage::class);
    }
}
