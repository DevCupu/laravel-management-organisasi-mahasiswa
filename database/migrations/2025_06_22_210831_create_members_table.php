<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('student_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->date('join_date');
            $table->enum('status', ['active', 'inactive', 'alumni'])->default('active');
            $table->string('photo_path')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'organization_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
