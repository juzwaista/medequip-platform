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
        Schema::table('users', function (Blueprint $table) {
            // Check if role column doesn't exist (might exist from previous migration)
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'distributor', 'customer'])
                    ->default('customer')
                    ->after('email');
            }

            // Social authentication columns
            $table->string('phone_number', 20)->nullable()->after('email');
            $table->string('social_provider', 50)->nullable()->after('password');
            $table->string('social_id')->nullable()->after('social_provider');

            // Add indexes
            $table->index('role');
            $table->index(['social_provider', 'social_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['social_provider', 'social_id']);

            $table->dropColumn([
                'phone_number',
                'social_provider',
                'social_id'
            ]);
        });
    }
};
