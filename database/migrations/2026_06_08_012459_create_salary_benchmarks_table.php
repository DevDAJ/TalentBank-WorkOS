<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->string('role_title');
            $table->string('seniority_level');
            $table->string('location');
            $table->integer('p25');
            $table->integer('p50');
            $table->integer('p75');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_benchmarks');
    }
};
