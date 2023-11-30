<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taskable_task_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taskable_task_id')->references('id')->on('taskable_tasks')->onDelete('cascade');
            $table->double('amount');
            $table->date('created_date')->default(DB::raw('CURRENT_DATE'));
            $table->timestamps();

            $table->unique(['taskable_task_id', 'created_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskable_task_tracks');
    }
};
