<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIncomeDailyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_daily', function (Blueprint $table) {
            // Remove the 'amount' column
            $table->dropColumn('amount');

            // Rename 'discount_amount' to 'discount_time'
            $table->renameColumn('discount_amount', 'discount_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_daily', function (Blueprint $table) {
            // Add back the 'amount' column
            $table->decimal('amount', 8, 2)->nullable();

            // Rename 'discount_time' back to 'discount_amount'
            $table->renameColumn('discount_time', 'discount_amount');
        });
    }
}
