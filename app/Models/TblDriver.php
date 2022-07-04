<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblDriver extends Model
{
    protected $table = 'tbl_driver';
	public $timestamps = false;
    protected $fillable = ['DriverID','CustomerID','FirstName','LastName','PagerNumber','Phone','Mobile','Email','Gst_no','StreetAddress1','StreetAddress2','StreetArea','Company_Driver','Status','WhoCreated','DateCreated','WhoModified','DateModified'];
    use HasFactory;
}
