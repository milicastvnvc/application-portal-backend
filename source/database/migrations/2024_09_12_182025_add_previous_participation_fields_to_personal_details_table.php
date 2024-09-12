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
            $table->string('name_of_host_institution_1')->nullable();
            $table->date('mobility_date_1')->nullable();
            $table->string('name_of_host_institution_2')->nullable();
            $table->date('mobility_date_2')->nullable();
            $table->string('name_of_host_institution_3')->nullable();
            $table->date('mobility_date_3')->nullable();
            $table->string('name_of_host_institution_4')->nullable();
            $table->date('mobility_date_4')->nullable();
            $table->string('name_of_host_institution_5')->nullable();
            $table->date('mobility_date_5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_details', function (Blueprint $table) {
            $table->dropColumn([
                'name_of_host_institution_1',
                'mobility_date_1',
                'name_of_host_institution_2',
                'mobility_date_2',
                'name_of_host_institution_3',
                'mobility_date_3',
                'name_of_host_institution_4',
                'mobility_date_4',
                'name_of_host_institution_5',
                'mobility_date_5',
            ]);
        });
    }
};
