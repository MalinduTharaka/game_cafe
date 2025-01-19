<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id'); // Foreign key to devices table
            $table->integer('duration'); // Duration in minutes or hours
            $table->decimal('amount', 10, 2); // Amount with 2 decimal places
            $table->boolean('discount_availability'); // Discount availability (true/false)
            $table->decimal('discount_amount', 10, 2)->nullable(); // Discount amount, nullable if no discount
            $table->date('date'); // Billing date
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
