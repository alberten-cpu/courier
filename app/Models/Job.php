<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'job';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id',
        'customer_reference',
        'from_address_id',
        'to_address_id',
        'from_area_id',
        'to_area_id',
        'timeframe_id',
        'notes',
        'van_hire',
        'number_box',
        'job_increment_id',
        'status_id'
    ];
}
