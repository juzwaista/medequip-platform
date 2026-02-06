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
        Schema::create('dss_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_id')->nullable()->constrained('inventory')->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('alert_type', ['low_stock', 'expiry_warning', 'dead_stock', 'overdue_payment']);
            $table->enum('severity', ['critical', 'warning', 'info'])->default('info');
            $table->string('title');
            $table->text('message');
            $table->json('metadata')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['distributor_id', 'is_read']);
            $table->index('severity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dss_alerts');
    }
};
