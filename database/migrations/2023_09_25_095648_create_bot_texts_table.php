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
        Schema::create('bot_texts', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('locale');
            $table->string('translation')->nullable();;
            $table->timestamps();

            $table->index(['key', 'locale']);
            $table->unique(['key', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_texts');
    }
};
