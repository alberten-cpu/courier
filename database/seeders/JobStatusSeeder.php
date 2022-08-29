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
            'status' => 'Order Placed',
            'identifier' => 'order_placed',
        ]);

        JobStatus::create([
            'status' => 'Driver Accepted',
            'identifier' => 'driver_accepted',
        ]);

        JobStatus::create([
            'status' => 'Driver Rejected',
            'identifier' => 'driver_rejected',
        ]);

        JobStatus::create([
            'status' => 'Order Delivered',
            'identifier' => 'order_delivered',
        ]);

        JobStatus::create([
            'status' => 'Delivery Pending',
            'identifier' => 'delivery_pending',
        ]);
    }
}
