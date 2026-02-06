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
        Schema::table('distributors', function (Blueprint $table) {
            // Only add columns that don't already exist
            // description and logo_path already exist, so skip them
            $table->string('slug')->unique()->nullable()->after('company_name');
            $table->string('cover_photo_path')->nullable()->after('description');
            $table->string('phone')->nullable()->after('cover_photo_path');
            $table->string('website')->nullable()->after('phone');
            $table->json('business_hours')->nullable()->after('website');
            $table->json('social_links')->nullable()->after('business_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributors', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'cover_photo_path',
                'phone',
                'website',
                'business_hours',
                'social_links',
            ]);
        });
    }
};
