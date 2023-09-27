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
            $table->foreignIdFor(\App\Models\Bots\Users\BotUser::class);
            $table->foreignIdFor(\App\Models\Bots\Categories\BotCategory::class)->nullable();
            $table->foreignIdFor(\App\Models\Bots\Categories\BotUserCategory::class)->nullable();
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
