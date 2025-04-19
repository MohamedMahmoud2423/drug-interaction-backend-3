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
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable(); // Optional: link to users table
        $table->string('full_name');
        $table->enum('gender', ['male', 'female', 'other']);
        $table->date('date_of_birth');
        $table->string('email')->unique()->nullable();
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

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
