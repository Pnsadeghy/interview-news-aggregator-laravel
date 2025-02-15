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
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('news_reader_source_id')->nullable()->constrained();
            $table->foreignUuid('news_source_id')->nullable()->constrained();

            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('is_published');
            $table->string('url')->unique()->nullable();
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->text('body')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
