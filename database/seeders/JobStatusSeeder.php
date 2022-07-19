<?php

namespace Database\Seeders;

use App\Models\JobStatus;
use Illuminate\Database\Seeder;

class JobStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobStatus::create([
            'status' => 'Placed',
            'identifier' => 'placed',
        ]);

        JobStatus::create([
            'status' => 'Driver Accepted',
            'identifier' => 'driver_accepted',
        ]);
    }
}
