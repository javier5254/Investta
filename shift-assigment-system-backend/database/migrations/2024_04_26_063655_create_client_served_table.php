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
        Schema::create('client_served', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_served');
    }
};
