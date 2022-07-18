<?php

namespace Database\Seeders;

use App\Models\TimeFrame;

use Illuminate\Database\Seeder;

class TimeFrames extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TimeFrame::create([
            'time_frame' => '1 hr',
            'status' => '1',
        ]);
    }
}
