<?php

namespace Database\Seeders;

use App\Models\NewsReaderSource;
use Database\Factories\NewsReaderSourceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsReaderSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (NewsReaderSource::query()->exists()) {
            return;
        }

        NewsReaderSource::factory()->create([
            'name' => 'NewsApi.org',
            'api_url' => 'https://newsapi.org/v2/top-headlines',
            'api_key' => env('NEWS_API_ORG_API_KEY'),
            'reader_class' => 'NewsApiOrgReader',
            'request_data' => [
                'country' => 'us'
            ]
        ]);

        NewsReaderSource::factory()->create([
            'name' => 'TheGuardian.com',
            'api_url' => 'https://content.guardianapis.com/search',
            'api_key' => env('THE_GUARDIAN_API_KEY'),
            'reader_class' => 'TheGuardianReader',
            'request_data' => []
        ]);

        NewsReaderSource::factory()->create([
            'name' => 'NewsApi.ai',
            'api_url' => 'https://eventregistry.org/api/v1/article/getArticles',
            'api_key' => env('NEWS_API_AI_API_KEY'),
            'reader_class' => 'NewsApiAiReader',
            'request_data' => [
                'lang' => 'eng'
            ]
        ]);
    }
}
