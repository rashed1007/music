<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\CarCondition;
use App\Enums\UserStatus;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;


class User extends Authenticatable implements HasMedia

{
    use HasApiTokens, HasFactory, Notifiable, HasFactory, InteractsWithMedia, SoftDeletes;

    protected $guard_name = 'users_api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'country',
        'city',
        'area',
        'lat',
        'lon',
        'address',
        'otp',
        'lang',
        'status',
        'last_login',
        'otp_expires_at',
        'phone_verified_at',
    ];

    protected $hidden = [
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        'last_login'        => 'datetime',
        'otp_expires_at'    => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}
