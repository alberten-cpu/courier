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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Wildside\Userstamps\Userstamps;

class Job extends Model
{
    use HasFactory;
    use Userstamps;

    public const JOB_ID_PREFIX = 'JOB';

    /**
     * @var string
     */
    protected $table = 'jobs';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id',
        'customer_contact_id',
        'from_area_id',
        'to_area_id',
        'timeframe_id',
        'notes',
        'van_hire',
        'number_box',
        'job_increment_id',
        'status_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['van_hire' => 'boolean'];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($job) {
            $job->fromAddress()->delete();
            $job->toAddress()->delete();
            $job->jobAssign()->delete();
            $job->dailyJob()->delete();
        });
    }

    /**
     * @return HasOne
     */
    public function fromAddress(): HasOne
    {
        return $this->hasOne(JobAddress::class)->where('type', 'from');
    }

    /**
     * @return HasOne
     */
    public function toAddress(): HasOne
    {
        return $this->hasOne(JobAddress::class)->where('type', 'to');
    }

    /**
     * @return HasOne
     */
    public function jobAssign(): HasOne
    {
        return $this->hasOne(JobAssign::class, 'job_id', 'id')->orderBy('status', 'desc');
    }

    /**
     * @return HasOne
     */
    public function dailyJob(): HasOne
    {
        return $this->HasOne(DailyJob::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function fromArea(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'from_area_id');
    }

    /**
     * @return BelongsTo
     */
    public function toArea(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'to_area_id');
    }

    /**
     * @return BelongsTo
     */
    public function timeFrame(): BelongsTo
    {
        return $this->belongsTo(TimeFrame::class, 'timeframe_id');
    }

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(JobStatus::class, 'status_id');
    }

    /**
     * @return BelongsTo
     */
    public function customerContact(): BelongsTo
    {
        return $this->belongsTo(CustomerContact::class, 'customer_contact_id');
    }

    /**
     * @param int $id
     * @return string
     */
    public function createIncrementJobId(int $id): string
    {
        return self::JOB_ID_PREFIX . str_pad($id, 5, 0, STR_PAD_LEFT);
    }

    /**
     * Get the class being used to provide a User.
     *
     * @return string
     */
    protected function getUserClass(): string
    {
        return config('auth.providers.user.model');
    }
}
