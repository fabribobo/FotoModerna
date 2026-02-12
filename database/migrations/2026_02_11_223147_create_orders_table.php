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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('service_type'); // e.g., 'basic', 'premium', 'wedding'
            $table->decimal('amount', 8, 2);
            $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->datetime('paid_at')->nullable();
            $table->string('download_token')->nullable(); // For temporary URLs
            $table->datetime('download_expires_at')->nullable(); // 30 giorni dalla data di pagamento
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['download_token', 'download_expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
