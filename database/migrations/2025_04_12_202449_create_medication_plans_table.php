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
        Schema::create('medication_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('medication_name');
            $table->string('dosage')->nullable(); // e.g., "1 tablet"
            $table->time('time'); // e.g., "08:00 AM"
            $table->string('note')->nullable(); // optional notes
            $table->date('date'); // the day it should be taken
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_plans');
    }
};
