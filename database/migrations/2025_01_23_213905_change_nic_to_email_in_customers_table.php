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
        Schema::table('customers', function (Blueprint $table) {
            // Rename the 'nic' column to 'email' and ensure it is unique
            $table->renameColumn('nic', 'email');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Revert the 'email' column back to 'nic' and remove the unique constraint
            $table->dropUnique(['email']);
            $table->renameColumn('email', 'nic');
        });
    }
};
