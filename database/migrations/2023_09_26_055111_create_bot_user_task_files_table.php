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
        Schema::create('bot_user_task_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bot_user_task_id')->references('id')->on('bot_user_tasks')->onDelete('cascade');
            $table->string('file_id');
            $table->string('file_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_task_files');
    }
};
