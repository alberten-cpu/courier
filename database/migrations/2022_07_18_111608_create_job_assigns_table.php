<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->referances('id')->constrained('jobs');
            $table->foreignId('user_id')->nullable()->referances('id')->constrained('users');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_assigns');
    }
}
