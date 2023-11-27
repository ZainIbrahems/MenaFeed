<?php

namespace App\Services;

use App\Models\Livestream;

class LiveStreamService{
    public static function get($livestram_id){
        return Livestream::withCount(['likes', 'dis_likes', 'comments'])->where('id', $livestram_id)->get()->toArray();
    }
}