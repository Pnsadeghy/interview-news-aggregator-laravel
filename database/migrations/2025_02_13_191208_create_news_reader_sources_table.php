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
        Schema::create('news_reader_sources', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('api_url');
            $table->string('api_key');
            $table->json('request_data');
            $table->string('reader_class');
            $table->boolean('is_enabled');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_reader_sources');
    }
};
