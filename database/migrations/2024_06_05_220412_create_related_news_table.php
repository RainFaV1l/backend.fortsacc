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
        Schema::create('related_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('related_news_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('related_news');
    }
};
