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
        Schema::table('licenses', function (Blueprint $table) {
            $table->string('license_number', 100)->nullable()->after('type');
            $table->date('issue_date')->nullable()->after('file_path');
            $table->date('expiry_date')->nullable()->after('issue_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropColumn(['license_number', 'issue_date', 'expiry_date']);
        });
    }
};
