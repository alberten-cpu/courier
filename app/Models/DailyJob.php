<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyJob extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'daily_job';

    /**
     * @var string[]
     */
    protected $fillable = ['job_id',
        'job_number',

    ];

}
