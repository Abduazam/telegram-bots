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
        Schema::create('bot_user_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_user_id')->references('id')->on('bot_users')->onDelete('cascade');
            $table->foreignId('bot_category_id')->nullable()->references('id')->on('bot_categories')->nullOnDelete();
            $table->string('description');
            $table->integer('amount')->nullable();
            $table->time('schedule_time')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tasks');
    }
};
