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
        Schema::create('expected_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('matricola', 50);
            $table->string('name')->nullable();
            $table->foreignId('matched_lead_id')->nullable()->constrained('leads')->nullOnDelete();
            $table->timestamps();

            $table->unique(['event_id', 'matricola']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expected_students');
    }
};
