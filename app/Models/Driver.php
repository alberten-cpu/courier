<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    protected $fillable = ['user_id', 'driver_id', 'area_id', 'pager_number'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
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
