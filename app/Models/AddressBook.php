<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'address_book';

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
}
