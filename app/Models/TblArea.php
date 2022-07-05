<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblArea extends Model
{
    protected $table = 'tbl_area';
	public $timestamps = false;
    protected $fillable = ['Area','Zone','Dispatch','Status'];
    use HasFactory;
}
