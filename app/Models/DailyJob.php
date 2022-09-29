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
