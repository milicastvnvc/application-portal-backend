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
        Schema::table('personal_details', function (Blueprint $table) {
            $table->string('previous_host_institution')->nullable()->after('disadvantaged');
            $table->text('mobility_dates')->nullable()->after('previous_host_institution'); // Use text if mobility_dates is a list or multiple dates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_details', function (Blueprint $table) {
            $table->dropColumn(['previous_host_institution', 'mobility_dates']);
        });
    }
};
