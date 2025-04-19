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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->string('full_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('phone_number')->nullable();

        // Medical Info
            $table->string('blood_type')->nullable();
            $table->json('allergies')->nullable(); // JSON array of allergies
            $table->json('chronic_conditions')->nullable(); // e.g., ["Diabetes", "Asthma"]
            $table->json('medications')->nullable(); // optional - for current meds
            $table->json('prescription')->nullable();
            $table->boolean('pregnancy_status')->nullable(); // relevant for females
            $table->float('weight')->nullable(); // in kg
            $table->float('height')->nullable(); // in cm
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
