<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 */
class Driver extends Model
{
    use HasFactory;

    public const DRIVER_ID_PREFIX = 'DID';
    /**
     * @var string
     */
    protected $table = 'drivers';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'driver_id','area_id','pager_number', 'street_address_1', 'street_address_2'];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @param int $id
     * @return string
     */
    public function createIncrementDriverId(int $id): string
    {
        return self::DRIVER_ID_PREFIX . str_pad($id, 5, 0, STR_PAD_LEFT);
    }
}
