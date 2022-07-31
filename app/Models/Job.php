<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'customer_reference',
        'from_address_id',
        'to_address_id',
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
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function fromAddress(): BelongsTo
    {
        return $this->belongsTo(AddressBook::class, 'from_address_id');
    }

    /**
     * @return BelongsTo
     */
    public function toAddress(): BelongsTo
    {
        return $this->belongsTo(AddressBook::class, 'to_address_id');
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
     * @return HasMany
     */
    public function jobAssign(): HasMany
    {
        return $this->hasMany(JobAssign::class, 'job_id', 'id')->where('status', true);
    }

    /**
     * @return HasOne
     */
    public function dailyJob(): HasOne
    {
        return $this->HasOne(DailyJob::class);
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
