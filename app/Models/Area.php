<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'areas';

    /**
     * @var string[]
     */
    protected $fillable = ['area',
        'zone_id',
        'dispatch',
        'status'];

    public static function getAreas(){

        return Area::where('status',true)->pluck('area','id')->toArray();
    }
}

