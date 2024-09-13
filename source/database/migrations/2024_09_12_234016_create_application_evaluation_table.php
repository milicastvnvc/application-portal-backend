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
        Schema::create('application_evaluation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->float('averageGrade')->nullable();
            $table->float('additionalEngagement')->nullable();
            $table->integer('yearLevelStudy')->nullable();
            $table->float('totalAchievement')->nullable();
            $table->float('applicationQuality')->nullable();
            $table->float('previousErasmusParticipation')->nullable();
            $table->float('programLanguageSkills')->nullable();
            $table->float('totalOther')->nullable();
            $table->float('overallResult')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_evaluation');
    }
};
