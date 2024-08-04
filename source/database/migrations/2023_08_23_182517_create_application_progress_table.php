<?php

use App\Enums\FormProgress;
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
        Schema::create('application_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->unsignedTinyInteger('personal_details')->default(FormProgress::Incompleted->value);
            $table->unsignedTinyInteger('home_institution')->default(FormProgress::Incompleted->value);
            $table->unsignedTinyInteger('proposed_host_universities')->default(FormProgress::Incompleted->value);
            $table->unsignedTinyInteger('motivation_and_added_value')->default(FormProgress::Incompleted->value);
            $table->unsignedTinyInteger('documents_upload')->default(FormProgress::Incompleted->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_progress');
    }
};
