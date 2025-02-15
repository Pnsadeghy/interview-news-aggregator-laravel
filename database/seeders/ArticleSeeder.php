<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\NewsSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Article::query()->exists()) {
            return;
        }

        $categories = Category::factory()->count(10)->create()->toArray();
        $newsSources = NewsSource::factory()->count(5)->create();

        foreach ($newsSources as $newsSource) {
            $authors = Author::factory()->count(5)->create([
                'news_source_id' => $newsSource->id
            ])->toArray();

            $articleCount = rand(1, 10);

            for ($i = 0; $i < $articleCount; $i++) {
                $article = Article::factory()->create([
                    'news_source_id' => $newsSource->id,
                    'title' => "Article " . ($i + 1) . " for " . $newsSource->title . " - " . rand(1, 10),
                ]);

                $article->authors()->attach($authors[array_rand($authors)]['id']);
                $article->categories()->attach($categories[array_rand($categories)]['id']);
            }
        }
    }
}
