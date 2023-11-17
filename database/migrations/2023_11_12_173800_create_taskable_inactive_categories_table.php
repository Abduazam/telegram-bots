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
        Schema::create('taskable_inactive_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_user_id')->references('id')->on('bot_users')->onDelete('cascade');
            $table->foreignId('taskable_category_id')->references('id')->on('taskable_categories')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['bot_user_id', 'taskable_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskable_inactive_categories');
    }
};
