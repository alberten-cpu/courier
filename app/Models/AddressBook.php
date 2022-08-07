<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddressBook extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'address_books';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id',
        'street_address',
        'suburb',
        'city',
        'state',
        'zip',
        'country',
        'place_id',
        'latitude',
        'longitude',
        'location_url',
        'full_json_response',
        'status',
        'set_as_default'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['status' => 'boolean', 'set_as_default' => 'boolean'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
