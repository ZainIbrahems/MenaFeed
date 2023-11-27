<?php

namespace TCG\Voyager\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TCG\Voyager\Contracts\User as UserContract;
use TCG\Voyager\Tests\Database\Factories\UserFactory;
use TCG\Voyager\Traits\VoyagerUser;

class User extends Authenticatable implements UserContract
{
    use VoyagerUser, HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    public $additional_attributes = ['locale'];

    public function getAvatarAttribute($value)
    {
        return $value ?? config('voyager.user.default_personal_picture', 'users/default.png');
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = $value ? $value->toJson() : json_encode([]);
    }

    public function getSettingsAttribute($value)
    {
        return collect(json_decode($value));
    }

    public function setLocaleAttribute($value)
    {
        $this->settings = $this->settings->merge(['locale' => $value]);
    }

    public function getLocaleAttribute()
    {
        return $this->settings->get('locale');
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }


    public function scopeShow($q)
    {
        if (auth('web')->user()->role_id != 1) {
            return $q->where('role_id', '<>', getRoleID('sm-admin'))
                ->where('role_id', '<>', getRoleID('provider'));
        }
    }

    public function scopeAddedBy($q)
    {
        if (auth('web')->user()->role_id == getRoleID('provider')) {
            return $q->where('id', auth('web')->user()->id);
        } else {
            return $q->where('role_id', getRoleID('provider'));
        }
    }
}
