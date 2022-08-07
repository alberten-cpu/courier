<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'customer_contacts';
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'customer_contact'];
}
