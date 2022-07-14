<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'job_status';

    /**
     * @var string[]
     */
    protected $fillable = ['status',
        'identifier'
    ];

}