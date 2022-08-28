<?php

/**
 * PHP Version 7.4.25
 * Laravel Framework 8.83.18
 *
 * @category Model
 *
 * @package Laravel
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 *
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 28/08/22
 * */

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
        'street_number',
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
