<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblUser extends Model
{
	protected $table = 'tbl_user';
	public $timestamps = false;
	//protected $fillable = ['user_email', 'user_password'];
    use HasFactory;

}
