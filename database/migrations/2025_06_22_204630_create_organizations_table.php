<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('acronym')->unique();
            $table->enum('category', ['himpunan', 'ukm', 'ormawa', 'bem', 'osis']);
            $table->text('description')->nullable();
            $table->date('established_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('logo_path')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('social_media')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
