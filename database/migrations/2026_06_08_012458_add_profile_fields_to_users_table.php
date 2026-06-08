<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('location')->nullable()->after('phone');
            $table->string('title')->nullable()->after('location');
            $table->text('summary')->nullable()->after('title');
            $table->string('website')->nullable()->after('summary');
            $table->string('linkedin_url')->nullable()->after('website');
            $table->string('github_url')->nullable()->after('linkedin_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'location', 'title', 'summary', 'website', 'linkedin_url', 'github_url']);
        });
    }
};
