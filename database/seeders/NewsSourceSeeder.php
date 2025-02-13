<?php

namespace Database\Seeders;

use App\Models\NewsSource;
use Database\Factories\NewsSourceFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (NewsSource::query()->exists()) {
            return;
        }

        $sources = [
            ['NewsApi.org', 'https://newsapi.org/v2/everything', '545cf89103b3440990a20881bf5d743a', 'NewsApiOrgReader'],
            ['TheGuardian.com', 'https://content.guardianapis.com/search', '42f3d8bb-a913-483d-8cb6-5bb4d6d06053', 'TheGuardianReader'],
            ['NewsApi.ai', 'https://eventregistry.org/api/v1/article/getArticles', '98397896-22bd-4e67-b8e0-0f6226681c47', 'NewsApiAiReader']
        ];

        foreach ($sources as $source) {
            NewsSource::factory()->create([
                'name' => $source[0],
                'api_url' => $source[1],
                'api_key' => $source[2],
                'reader_class' => $source[3]
            ]);
        }
    }
}
