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
        Schema::create('thread_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('thread_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'thread_id']); // 1 user cuma bisa like 1 kali
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thread_likes');
    }
};
