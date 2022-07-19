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
        'type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'country',
        'status',
        'set_us_default'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
