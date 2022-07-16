<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->referances('id')->constrained('users');
            $table->string('customer_reference');
            $table->foreignId('from_address_id')->nullable()->referances('id')->constrained('address_books');
            $table->string('to_address_id')->nullable()->referances('id')->constrained('address_books');
            $table->foreignId('from_area_id')->nullable()->referances('id')->constrained('areas');
            $table->foreignId('to_area_id')->nullable()->referances('id')->constrained('areas');
            $table->foreignId('timeframe_id')->nullable()->referances('id')->constrained('time_frames');
            $table->string('notes')->nullable();
            $table->boolean('van_hire')->default(false);
            $table->integer('number_box')->nullable();
            $table->string('job_increment_id')->nullable();
            $table->foreignId('status_id')->nullable()->referances('id')->constrained('job_status');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->referances('id')->constrained('users');
            $table->foreignId('updated_by')->nullable()->referances('id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
