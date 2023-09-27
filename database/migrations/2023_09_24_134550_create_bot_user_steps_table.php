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
        Schema::create('bot_user_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Bots\Users\BotUser::class);
            $table->smallInteger('step_one');
            $table->smallInteger('step_two');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_user_steps');
    }
};
