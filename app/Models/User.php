<?php

namespace App\Models;

use App\Http\Controllers\Admin\SubSubCategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Traits\Resizable;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;
    use Resizable;


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForFcm($notification)
    {
        return $this->fcm_token;
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }
}
