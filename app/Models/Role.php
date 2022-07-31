<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class Role extends Model
{
    use HasFactory;

    public const ADMIN = 1;
    public const CUSTOMER = 2;
    public const DRIVER = 3;
    /**
     * @var string
     */
    protected $table = 'roles';
    /**
     * @var string[]
     */
    protected $fillable = ['role',
        'role_identifier',
        'role_level',
        'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['status' => 'boolean'];

    /**
     * Get the user relationship.
     *
     * @return HasMany user data
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
