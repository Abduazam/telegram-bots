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
        Schema::create('bot_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Bots\Categories\BotCategory::class);
            $table->string('locale');
            $table->string('translation')->nullable();
            $table->timestamps();

            $table->unique(['bot_category_id', 'locale']);
            $table->index(['bot_category_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_category_translations');
    }
};
