<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'from_id',
        'from_type',
        'to_id',
        'to_type',
        'last_message',
        'last_message_from',
        'from_deleted',
        'from_deleted_at',
        'to_deleted',
        'to_deleted_at'
    ];

    public function from()
    {
        if($this->from_type=='client'){
            return $this->belongsTo(Client::class, 'from_id');
        }else{
            return $this->belongsTo(Provider::class, 'from_id');
        }
    }

    public function to()
    {
        if($this->to_type=='client'){
            return $this->belongsTo(Client::class, 'to_id');
        }else{
            return $this->belongsTo(Provider::class, 'to_id');
        }
    }

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
