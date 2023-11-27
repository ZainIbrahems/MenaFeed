<?php

namespace App\Models;

use App\Http\Controllers\Admin\SubSubCategoryController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Traits\Resizable;

class UserFollow extends Model
{
    protected $table = 'users_follow';
}
