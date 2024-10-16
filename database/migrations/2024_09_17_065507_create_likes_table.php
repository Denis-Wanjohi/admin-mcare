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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('blog_id')->nullable();
            // $table->unsignedBigInteger('news_id')->nullable();
            // $table->unsignedBigInteger('event_id')->nullable();
            // $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade')->nullable();
            // $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade')->nullable();
            // $table->foreign('events_id')->references('id')->on('events')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
