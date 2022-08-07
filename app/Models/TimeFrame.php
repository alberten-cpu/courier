<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeFrame extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'time_frames';

    /**
     * @var string[]
     */
    protected $fillable = ['time_frame',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['status' => 'boolean'];
}
