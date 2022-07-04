<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblCustomer extends Model
{
    protected $table = 'tbl_customer';
	public $timestamps = false;
    protected $fillable = ['CustomerID','CustomerName','FirstName','LastName','Phone','Mobile','Email','StreetAddress1','StreetAddress2','StreetArea','BillingAddress1','BillingAddress2','BillingArea','Status','WhoCreated','DateCreated','WhoModified','DateModified'];
    use HasFactory;
}
