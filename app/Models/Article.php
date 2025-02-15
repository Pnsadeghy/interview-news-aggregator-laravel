<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'news_reader_source_id',
        'news_source_id',
        'title',
        'is_published',
        'url',
        'image_url',
        'description',
        'body',
        'published_at'
    ];

    protected $attributes = [
        'is_published' => true
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime'
        ];
    }

    /**
     * Generate the slug from the title.
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($article) {
            if (!$article->slug) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    #region Relations
    public function newsReaderSource(): BelongsTo
    {
        return $this->belongsTo(NewsReaderSource::class);
    }

    public function newsSource(): BelongsTo
    {
        return $this->belongsTo(NewsSource::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, "article_categories");
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, "article_authors");
    }
    #endregion

    /**
     * Published scope
     */
    public function scopePublished($query): void
    {
        $query->where('is_published', true);
    }
}
