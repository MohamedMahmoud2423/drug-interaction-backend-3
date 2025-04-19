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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->text('contraindications')->nullable();
            $table->string('severity')->nullable();
            $table->text('risk_description')->nullable();
            $table->string('contraindications_type')->nullable();
            $table->string('severity_level')->nullable();
            $table->string('allergy_risks')->nullable();
            $table->string('age_groups')->nullable();
            $table->text('pregnancy_safety')->nullable();
            $table->text('drug_interactions')->nullable();
            $table->text('drug_drug_interactions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
