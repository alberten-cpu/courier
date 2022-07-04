<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblUser extends Model
{
	protected $table = 'tbl_user';
	public $timestamps = false;
	protected $fillable = ['cid','CustomerID','Email','Password','Firstname','Lastname','Status','User_role','Created_at','Updated_at'];
    use HasFactory;

}
