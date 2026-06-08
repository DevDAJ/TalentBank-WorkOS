<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('suggested_role');
            $table->text('description')->nullable();
            $table->integer('match_score')->default(0);
            $table->json('progression_path')->nullable();
            $table->json('skill_coverage')->nullable();
            $table->json('skill_gaps')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_suggestions');
    }
};
