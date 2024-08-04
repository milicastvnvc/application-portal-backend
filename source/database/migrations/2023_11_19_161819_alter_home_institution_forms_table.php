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
        Schema::table('home_institution_forms', function (Blueprint $table) {
            $table->decimal('current_grade', $precision = 5, $scale = 2)->nullable()->change();
            $table->decimal('previous_gpa', $precision = 5, $scale = 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_institution_forms', function (Blueprint $table) {
            $table->float('current_grade')->nullable()->change();
            $table->float('previous_gpa')->nullable()->change();
        });
    }
};
