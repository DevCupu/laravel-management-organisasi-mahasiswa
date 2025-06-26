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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['general', 'urgent', 'event', 'reminder'])->default('general');
            $table->enum('target_audience', ['all', 'members', 'specific'])->default('all');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('publish_date')->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
