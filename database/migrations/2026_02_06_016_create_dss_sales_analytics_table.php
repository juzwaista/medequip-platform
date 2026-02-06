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
        Schema::create('dss_sales_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->date('analysis_date');
            $table->enum('period_type', ['daily', 'weekly', 'monthly']);
            $table->integer('total_orders')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->integer('total_quantity_sold')->default(0);
            $table->decimal('average_order_value', 12, 2)->default(0);
            $table->json('top_products')->nullable();
            $table->timestamps();

            $table->unique(['distributor_id', 'analysis_date', 'period_type'], 'dss_analytics_unique');
            $table->index('analysis_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dss_sales_analytics');
    }
};
