<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAddress extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'job_id',
        'type',
        'company_name',
        'street_address',
        'suburb',
        'city',
        'state',
        'zip',
        'country',
        'place_id',
        'latitude',
        'longitude',
        'location_url',
        'full_json_response'];

    /**
     * @return BelongsTo
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
