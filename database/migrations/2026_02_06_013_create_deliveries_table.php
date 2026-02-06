<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('tracking_number', 50)->unique();
            $table->text('delivery_address');
            $table->date('scheduled_date')->nullable();
            $table->timestamp('actual_delivery_at')->nullable();
            $table->string('driver_name', 100)->nullable();
            $table->string('driver_contact', 20)->nullable();
            $table->string('proof_of_delivery_path')->nullable();
            $table->enum('status', ['pending', 'scheduled', 'in_transit', 'delivered', 'failed'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('scheduled_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
