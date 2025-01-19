<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('gmsessions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('device_id');
        $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        $table->timestamp('start_time')->nullable();
        $table->timestamp('end_time')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gmsessions');
    }
};
