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
        Schema::create('bot_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_id')->references('id')->on('bots')->onDelete('cascade');
            $table->bigInteger('chat_id');
            $table->string('first_name', 75);
            $table->string('username', 75)->nullable();
            $table->string('phone_number')->nullable();
            $table->boolean('is_view')->default(false);
            $table->tinyInteger('active')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['bot_id', 'chat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_users');
    }
};
