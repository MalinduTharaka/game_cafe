<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeDailyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_daily', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('date'); // Date column
            $table->decimal('duration', 8, 2); // Duration column
            $table->decimal('amount', 10, 2); // Amount column with 2 decimal precision
            $table->decimal('discount_amount', 10, 2); // Discount amount column with 2 decimal precision
            $table->decimal('total', 10, 2); // Total amount column with 2 decimal precision
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_daily');
    }
}

