<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyJob extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'daily_jobs';

    /**
     * @var string[]
     */
    protected $fillable = ['job_id', 'job_number'];

    /**
     * @return int
     */
    public static function getTodaysJobCount(): int
    {
        return DailyJob::whereDate('created_at', Carbon\Carbon::today())->count();
    }
}
