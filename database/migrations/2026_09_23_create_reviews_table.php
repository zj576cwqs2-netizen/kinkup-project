<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating'); // 1〜5
            $table->text('comment');
            $table->timestamps();

            $table->unique(['user_id', 'article_id']); // 1ユーザー1記事につき1レビュー
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};