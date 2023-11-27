<?php

namespace App\Models;

use App\Http\Controllers\Admin\SubSubCategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Traits\Resizable;
use TCG\Voyager\Traits\Spatial;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use Resizable;

    protected $table = 'clients';


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
