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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distributor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('sku', 100)->unique();
            $table->text('description');
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->decimal('base_price', 12, 2);
            $table->decimal('wholesale_price', 12, 2)->nullable();
            $table->integer('wholesale_min_qty')->nullable();
            $table->enum('product_type', ['equipment', 'supply', 'consumable'])->default('supply');
            $table->boolean('has_expiry')->default(false);
            $table->boolean('has_warranty')->default(false);
            $table->integer('warranty_months')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index(['category_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
