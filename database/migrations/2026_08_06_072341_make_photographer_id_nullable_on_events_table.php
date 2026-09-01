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
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['photographer_id']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('photographer_id')->nullable()->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('photographer_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['photographer_id']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('photographer_id')->nullable(false)->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('photographer_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};
