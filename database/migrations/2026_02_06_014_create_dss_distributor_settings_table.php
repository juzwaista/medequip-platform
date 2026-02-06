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
        Schema::create('dss_distributor_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->unique()->constrained()->cascadeOnDelete();
            $table->integer('low_stock_threshold_days')->default(7);
            $table->integer('expiry_warning_days')->default(60);
            $table->integer('dead_stock_days')->default(90);
            $table->boolean('enable_auto_alerts')->default(true);
            $table->json('custom_rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dss_distributor_settings');
    }
};
