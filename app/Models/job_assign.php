<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job_assign extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'job_assign';

    /**
     * @var string[]
     */
    protected $fillable = ['job_id',
        'driver_id',
        'status'
    ];
}
