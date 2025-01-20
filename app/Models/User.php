<?php

namespace App\Models;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\EmailVerificationController;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    public function passwordResetTokens(): HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }

    public function setVerificationTokenAttribute($value)
    {
        $this->attributes['verification_token'] = $value;
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
        'verification_token_expires_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

}
