<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAssign extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'job_assigns';

    /**
     * @var string[]
     */
    protected $fillable = ['job_id',
        'user_id',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['status' => 'boolean'];
}
