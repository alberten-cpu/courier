<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Wildside\Userstamps\Userstamps;

/**
 * @method static create(array $array)
 * @method static select(string $string, string $string1, string $string2, string $string3)
 */
class User extends Authenticatable implements
    AuthenticatableContract,
    CanResetPasswordContract,
    MustVerifyEmail
{
    use \Illuminate\Auth\Authenticatable;
    use CanResetPassword;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use Userstamps;

    /**
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'role_id',
        'is_admin',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_admin == 1;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role_id == Role::ADMIN;
    }

    /**
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->role_id == Role::CUSTOMER;
    }

    /**
     * @return bool
     */
    public function isDriver(): bool
    {
        return $this->role_id == Role::DRIVER;
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * @return HasOne
     */

    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    /**
     * @return HasOne
     */
    public function defaultAddress(): HasOne
    {
        return $this->hasOne(AddressBook::class)->where('status', true)->where('set_as_default', true);
    }

    /**
     * Get the class being used to provide a User.
     *
     * @return string
     */
    protected function getUserClass(): string
    {
        return config('auth.providers.user.model');
    }
}
