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
        Schema::create('personal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->string('surname');
            $table->string('fornames');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->unsignedTinyInteger('gender');
            $table->string('passport');
            $table->string('street');
            $table->unsignedMediumInteger('postcode');
            $table->string('city');
            $table->string('country');
            $table->string('telephone');
            $table->string('email');
            $table->string('alternative_email')->nullable();
            $table->boolean('disadvantaged')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_details');
    }
};
