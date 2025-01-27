<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            // Drop the 'amount' column
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
        Schema::table('bills', function (Blueprint $table) {
            // Add the 'amount' column back
            $table->decimal('amount', 8, 2);
            
            // Rename 'discount_time' back to 'discount_amount'
            $table->renameColumn('discount_time', 'discount_amount');
        });
    }
}
