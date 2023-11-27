<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatsReport extends Model
{
    protected $table = 'chats_reports';

    public function scopeActive($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            return $q->where(function ($qi) {
                return $qi->where([
                    'from_id' => auth('web')->user()->id,
                    'from_type' => 'provider'
                ]);
            })->orWhere(function ($qi) {
                return $qi->where([
                    'to_id' => auth('web')->user()->id,
                    'from_type' => 'provider'
                ]);
            });
        } else {
            return $q;
        }
    }
}
