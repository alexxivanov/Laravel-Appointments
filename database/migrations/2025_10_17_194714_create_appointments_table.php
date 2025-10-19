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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('scheduled_at');
            $table->string('client_name', 160);
            $table->string('egn', 10);
            $table->text('description')->nullable();
            $table->string('notification_method', 10);
            $table->timestamps();

            $table->index('scheduled_at');
            $table->index('egn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
