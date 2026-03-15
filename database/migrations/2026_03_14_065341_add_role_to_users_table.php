<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['peserta', 'juri', 'admin'])->default('peserta')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('region')->nullable()->after('phone');
            $table->boolean('is_verified')->default(false)->after('region');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'region', 'is_verified']);
        });
    }
};