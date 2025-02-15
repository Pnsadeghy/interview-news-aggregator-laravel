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
            'api_key' => '545cf89103b3440990a20881bf5d743a',
            'reader_class' => 'NewsApiOrgReader',
            'request_data' => [
                'country' => 'us'
            ]
        ]);

        NewsReaderSource::factory()->create([
            'name' => 'TheGuardian.com',
            'api_url' => 'https://content.guardianapis.com/search',
            'api_key' => '42f3d8bb-a913-483d-8cb6-5bb4d6d06053',
            'reader_class' => 'TheGuardianReader',
            'request_data' => []
        ]);

        NewsReaderSource::factory()->create([
            'name' => 'NewsApi.ai',
            'api_url' => 'https://eventregistry.org/api/v1/article/getArticles',
            'api_key' => '98397896-22bd-4e67-b8e0-0f6226681c47',
            'reader_class' => 'NewsApiAiReader',
            'request_data' => [
                'lang' => 'eng'
            ]
        ]);
    }
}
