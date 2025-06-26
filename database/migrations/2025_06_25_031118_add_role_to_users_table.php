<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'organization_admin', 'member'])->default('member')->after('email');
            $table->foreignId('organization_id')->nullable()->constrained()->onDelete('set null')->after('role');
            $table->string('student_id')->nullable()->after('organization_id');
            $table->string('phone')->nullable()->after('student_id');
            $table->timestamp('last_login_at')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('last_login_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn(['role', 'organization_id', 'student_id', 'phone', 'last_login_at', 'is_active']);
        });
    }
};
