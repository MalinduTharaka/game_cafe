<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->renameColumn('rate', 'rate1');
            $table->string('rate2')->nullable();
            $table->string('rate3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->renameColumn('rate1', 'rate');
            $table->dropColumn('rate2');
            $table->dropColumn('rate3');
        });
    }
};
