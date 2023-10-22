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
        Schema::create('home_institution_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->string('faculty', 255);
            $table->string('department', 255);
            $table->float('current_grade')->nullable();
            $table->float('previous_gpa')->nullable();
            $table->string('study_program', 255);
            $table->string('responsible_person', 255);
            $table->string('email_responsible_person', 255);
            $table->string('other_contact')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_institution_forms');
    }
};
