<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Traits\Resizable;
use TCG\Voyager\Traits\Spatial;
use TCG\Voyager\Traits\Translatable;

class Provider extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Spatial;

    protected $spatial = ['location'];
    use SoftDeletes;
    use Resizable;

    protected $table = 'providers';

    use Translatable;

    protected $translatable = ['full_name', 'summary', 'about'];


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

    public function scopeShow($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            return $q->where('user_id', '=', auth('web')->user()->id);
        }
        return $q;
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function abbreviation()
    {
        return $this->belongsTo(Abbreviation::class, 'abbreviation_id');
    }

    public function subscription()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_id');
    }

    public function category()
    {
        return $this->belongsTo(PlatformCategory::class, 'platform_category');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'providers_features');
    }


    public function specialities()
    {
        return $this->belongsToMany(PlatformSubSubCategory::class, 'providers_specialities');
    }

    public function speciality_groups()
    {
        return $this->belongsToMany(PlatformSubCategory::class, 'providers_speciality_groups');
    }

    public function awards()
    {
        return $this->hasMany(ProviderAward::class, 'provider_id')->orderBy('sort');
    }

    public function educations()
    {
        return $this->hasMany(ProviderEducation::class, 'provider_id')->orderBy('sort');
    }

    public function experiences()
    {
        return $this->hasMany(ProviderExperience::class, 'provider_id')->orderBy('sort');
    }

    public function professionals()
    {
        return $this->hasMany(ProvidersProfessional::class, 'provider_id');
    }

    public function memberships()
    {
        return $this->hasMany(ProviderMembership::class, 'provider_id')->orderBy('sort');
    }

    public function publications()
    {
        return $this->hasMany(ProviderPublication::class, 'provider_id')->orderBy('sort');
    }

    public function vacations()
    {
        return $this->hasMany(ProviderVacation::class, 'provider_id')->orderBy('sort');
    }

}
