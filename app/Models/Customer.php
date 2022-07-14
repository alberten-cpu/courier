<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static select(string $string, string $string1, string $string2, string $string3)
 */
class Customer extends Model
{
    use HasFactory;

    public const CUSTOMER_ID_PREFIX = 'CID';
    /**
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'customer_id', 'area_id', 'street_address_1', 'street_address_2'];

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
    public function createIncrementCustomerId(int $id): string
    {
        return self::CUSTOMER_ID_PREFIX . str_pad($id, 5, 0, STR_PAD_LEFT);
    }
}
