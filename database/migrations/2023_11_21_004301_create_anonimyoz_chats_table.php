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
        Schema::create('anonimyoz_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->references('id')->on('bot_users')->onDelete('cascade');
            $table->string('sender_username')->nullable();
            $table->foreignId('receiver_id')->nullable()->references('id')->on('bot_users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anonimyoz_chats');
    }
};
