<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('juri_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('design_id')->constrained()->onDelete('cascade');
            $table->integer('orisinalitas'); // bobot 30%
            $table->integer('estetika');     // bobot 25%
            $table->integer('budaya');       // bobot 25%
            $table->integer('teknis');       // bobot 20%
            $table->decimal('final_score', 5, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};