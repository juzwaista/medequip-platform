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
        Schema::create('dss_reorder_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('current_stock');
            $table->integer('recommended_quantity');
            $table->decimal('avg_daily_sales', 8, 2);
            $table->integer('days_until_stockout');
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->boolean('is_actioned')->default(false);
            $table->timestamps();

            $table->index(['distributor_id', 'is_actioned']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dss_reorder_recommendations');
    }
};
