<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('user_id');
            $table->string('phone')->nullable();
            $table->string('street_address_1');
            $table->string('street_address_2')->nullable();
            $table->string('street_area');
            $table->string('billing_address_1');
            $table->string('billing_address_2')->nullable();
            $table->string('billing_area')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->referances('id')->constrained('users');
            $table->foreignId('updated_by')->nullable()->referances('id')->constrained('users');
            $table->foreignId('deleted_by')->nullable()->referances('id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
